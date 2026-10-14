<?php

namespace App\Http\Controllers;

use App\Models\AppOperacaoSincronizacao;
use App\Models\AppPessoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;

class AppPessoaController extends Controller
{
    public function index()
    {
        return response()->json(AppPessoa::orderBy('id')->get());
    }

public function store(Request $request)
{
    $dados = $request->validate([
        'nome' => ['required', 'string', 'max:255'],
        'apelido' => ['nullable', 'string', 'max:255'],
    ]);

    /*
    |--------------------------------------------------------------------------
    | ID DA OPERAÇÃO
    |--------------------------------------------------------------------------
    */

    $idOperacao = $request->header('X-Operacao-Id');

    if (!$idOperacao) {

        return response()->json([
            'message' => 'ID da operação não informado.',
        ], 400);
    }

    if (!Str::isUuid($idOperacao)) {

        return response()->json([
            'message' => 'ID da operação inválido.',
        ], 400);
    }

    /*
    |--------------------------------------------------------------------------
    | VERIFICA SE A OPERAÇÃO JÁ FOI PROCESSADA
    |--------------------------------------------------------------------------
    |
    | Este teste resolve o caso normal de retry:
    |
    | primeira requisição -> operação já existe
    | segunda requisição  -> encontra a operação
    |
    */

    $operacaoExistente = AppOperacaoSincronizacao::where(
        'id_operacao',
        $idOperacao
    )->first();

    if ($operacaoExistente) {

        return response()->json(
            $operacaoExistente->resposta,
            201
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EXECUTA A OPERAÇÃO
    |--------------------------------------------------------------------------
    |
    | AppPessoa + auditoria + registro da operação de sincronização
    | ficam dentro da MESMA transação.
    |
    */

    try {

        $resposta = DB::transaction(function () use (
            $dados,
            $idOperacao
        ) {

            /*
            |--------------------------------------------------------------------------
            | CRIA A APP PESSOA
            |--------------------------------------------------------------------------
            */

            $app_pessoa = AppPessoa::create($dados);

            /*
            |--------------------------------------------------------------------------
            | REGISTRA A OPERAÇÃO
            |--------------------------------------------------------------------------
            |
            | A coluna id_operacao possui UNIQUE no banco.
            |
            | Portanto, se outra requisição simultânea estiver
            | usando o mesmo UUID, somente uma conseguirá gravá-lo.
            |
            */

            $operacao = AppOperacaoSincronizacao::create([
                'id_operacao' => $idOperacao,
                'tabela' => 'app_pessoas',
                'registro_id' => $app_pessoa->id,
                'operacao' => 'INSERT',
                'resposta' => $app_pessoa->toArray(),
            ]);

            return $operacao->resposta;
        });

        /*
        |--------------------------------------------------------------------------
        | OPERAÇÃO EXECUTADA COM SUCESSO
        |--------------------------------------------------------------------------
        */

        return response()->json(
            $resposta,
            201
        );

    } catch (QueryException $e) {

        /*
        |--------------------------------------------------------------------------
        | CONCORRÊNCIA / UUID DUPLICADO
        |--------------------------------------------------------------------------
        |
        | Pode acontecer o seguinte:
        |
        | Request A:
        |   cria AppPessoa
        |   grava id_operacao
        |   COMMIT
        |
        | Request B:
        |   tenta gravar o mesmo id_operacao
        |   banco rejeita por UNIQUE
        |
        | Neste caso, a transação da Request B sofre rollback.
        |
        | Depois do rollback podemos buscar com segurança
        | a operação que a Request A já gravou.
        |
        */

        $codigoErro = $e->errorInfo[1] ?? null;

        $sqlState = $e->errorInfo[0] ?? null;

        $erroDuplicado =
            $codigoErro === 1062 ||
            $sqlState === '23000';

        if (!$erroDuplicado) {

            /*
            |--------------------------------------------------------------------------
            | Não é erro de concorrência.
            |--------------------------------------------------------------------------
            |
            | Portanto, não escondemos o erro real.
            |
            */

            throw $e;
        }

        /*
        |--------------------------------------------------------------------------
        | RECUPERA A OPERAÇÃO ORIGINAL
        |--------------------------------------------------------------------------
        */

        $operacaoExistente = AppOperacaoSincronizacao::where(
            'id_operacao',
            $idOperacao
        )->first();

        if (!$operacaoExistente) {

            /*
            |--------------------------------------------------------------------------
            | Situação extremamente anormal:
            |
            | houve conflito de UNIQUE, mas a operação não está
            | disponível após o rollback.
            |--------------------------------------------------------------------------
            */

            throw $e;
        }

        /*
        |--------------------------------------------------------------------------
        | DEVOLVE EXATAMENTE A RESPOSTA DA PRIMEIRA EXECUÇÃO
        |--------------------------------------------------------------------------
        */

        return response()->json(
            $operacaoExistente->resposta,
            201
        );
    }
}


public function update(Request $request, int $id)
{
    $dados = $request->validate([
        'nome' => ['required', 'string', 'max:255'],
        'apelido' => ['nullable', 'string', 'max:255']
    ]);

    /*
     * ========================================================
     * ID DA OPERAÇÃO
     * ========================================================
     */

    $idOperacao = $request->header('X-Operacao-Id');

    if (!$idOperacao) {

        return response()->json([
            'message' => 'ID da operação não informado.',
        ], 400);
    }

    if (!Str::isUuid($idOperacao)) {

        return response()->json([
            'message' => 'ID da operação inválido.',
        ], 400);
    }

    /*
     * ========================================================
     * VERIFICA SE A OPERAÇÃO JÁ FOI EXECUTADA
     * ========================================================
     *
     * Isso atende o retry.
     *
     * Se a operação já foi executada anteriormente, devolvemos
     * a resposta original sem executar o UPDATE novamente.
     *
     */

    $operacaoExistente = AppOperacaoSincronizacao::where(
        'id_operacao',
        $idOperacao
    )->first();

    if ($operacaoExistente) {

        return response()->json(
            $operacaoExistente->resposta
        );
    }

    /*
     * ========================================================
     * EXECUTA UPDATE + AUDITORIA + IDEMPOTÊNCIA
     * DENTRO DA MESMA TRANSAÇÃO
     * ========================================================
     */

    try {

        $resposta = DB::transaction(function () use (
            $dados,
            $id,
            $idOperacao
        ) {

            /*
             * ====================================================
             * LOCALIZA A APP PESSOA
             * ====================================================
             */

            $app_pessoa = AppPessoa::findOrFail($id);

            /*
             * ====================================================
             * EXECUTA UPDATE
             * ====================================================
             *
             * O AppPessoaObserver::updated() será disparado aqui.
             *
             */

            $app_pessoa->update($dados);

            /*
             * ====================================================
             * CAPTURA A RESPOSTA
             * ====================================================
             */

            $resposta = $app_pessoa->fresh()->toArray();

            /*
             * ====================================================
             * REGISTRA A OPERAÇÃO DE SINCRONIZAÇÃO
             * ====================================================
             *
             * O id_operacao possui UNIQUE no banco.
             *
             * Portanto, uma segunda requisição concorrente
             * com o mesmo UUID não poderá registrar outra
             * operação.
             *
             */

            AppOperacaoSincronizacao::create([
                'id_operacao' => $idOperacao,
                'tabela' => 'app_pessoas',
                'registro_id' => $app_pessoa->id,
                'operacao' => 'UPDATE',
                'resposta' => $resposta,
            ]);

            return $resposta;
        });

        /*
         * ========================================================
         * IMPORTANTE:
         *
         * Neste ponto o DB::transaction() já terminou.
         *
         * Portanto:
         *
         * UPDATE
         *   ↓
         * registro da operação
         *   ↓
         * COMMIT
         *   ↓
         * estamos fora da transação
         *
         * Se ativarmos o teste abaixo, a alteração NÃO será
         * desfeita.
         * ========================================================
         */

        if (
            $request->header('X-Teste-Falha-Apos-Commit') === 'true'
        ) {

            throw new \Exception(
                'TESTE: resposta UPDATE perdida após COMMIT.'
            );
        }

        /*
         * ========================================================
         * RESPOSTA NORMAL
         * ========================================================
         */

        return response()->json(
            $resposta
        );

    } catch (QueryException $e) {

        /*
         * ========================================================
         * CONCORRÊNCIA / UUID DUPLICADO
         * ========================================================
         *
         * Duas requisições podem passar simultaneamente pela
         * verificação inicial.
         *
         * A restrição UNIQUE de id_operacao garante que somente
         * uma consiga registrar a operação.
         *
         */

        $codigoErro = $e->errorInfo[1] ?? null;

        $sqlState = $e->errorInfo[0] ?? null;

        $erroDuplicado =
            $codigoErro === 1062 ||
            $sqlState === '23000';

        /*
         * ========================================================
         * NÃO É DUPLICIDADE
         * ========================================================
         */

        if (!$erroDuplicado) {

            throw $e;
        }

        /*
         * ========================================================
         * RECUPERA A OPERAÇÃO ORIGINAL
         * ========================================================
         */

        $operacaoExistente = AppOperacaoSincronizacao::where(
            'id_operacao',
            $idOperacao
        )->first();

        if (!$operacaoExistente) {

            /*
             * Situação anormal:
             *
             * houve conflito de UNIQUE, mas a operação vencedora
             * não está disponível.
             *
             */

            throw $e;
        }

        /*
         * ========================================================
         * DEVOLVE A RESPOSTA ORIGINAL
         * ========================================================
         */

        return response()->json(
            $operacaoExistente->resposta
        );
    }
}


public function delete(Request $request, int $id)
{
    $idOperacao = $request->header('X-Operacao-Id');

    if (!$idOperacao) {

        return response()->json([
            'message' => 'ID da operação não informado.',
        ], 400);
    }

    if (!Str::isUuid($idOperacao)) {

        return response()->json([
            'message' => 'ID da operação inválido.',
        ], 400);
    }

    /*
     * IMPORTANTE:
     *
     * A verificação de idempotência precisa acontecer
     * ANTES do findOrFail().
     *
     * Em um retry, a AppPessoa já pode ter sido excluída.
     */

    $operacaoExistente = AppOperacaoSincronizacao::where(
        'id_operacao',
        $idOperacao
    )->first();

    if ($operacaoExistente) {

        return response()->json(
            $operacaoExistente->resposta
        );
    }

    try {

        $resposta = DB::transaction(function () use (
            $id,
            $idOperacao
        ) {

            $app_pessoa = AppPessoa::findOrFail($id);

            $resposta = [
                'message' => 'AppPessoa excluída com sucesso.',
                'id' => $app_pessoa->id,
            ];

            $app_pessoa->delete();

            AppOperacaoSincronizacao::create([
                'id_operacao' => $idOperacao,
                'tabela' => 'app_pessoas',
                'registro_id' => $id,
                'operacao' => 'DELETE',
                'resposta' => $resposta,
            ]);

            return $resposta;
        });

        return response()->json(
            $resposta
        );

    } catch (QueryException $e) {

        $codigoErro = $e->errorInfo[1] ?? null;
        $sqlState = $e->errorInfo[0] ?? null;

        $erroDuplicado =
            $codigoErro === 1062 ||
            $sqlState === '23000';

        if (!$erroDuplicado) {
            throw $e;
        }

        /*
         * Outra requisição concorrente pode ter gravado
         * a mesma operação primeiro.
         *
         * Nesse caso, recuperamos a resposta original.
         */

        $operacaoExistente = AppOperacaoSincronizacao::where(
            'id_operacao',
            $idOperacao
        )->first();

        if (!$operacaoExistente) {
            throw $e;
        }

        return response()->json(
            $operacaoExistente->resposta
        );
    }
}

}
