<?php

namespace App\Http\Controllers;

use App\Models\AppOperacaoSincronizacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;

class AppVistoriaSistemaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        return response()->json(
            DB::table('app_vistorias_sistemas')
                ->orderBy('id')
                ->get()
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    |
    | A Vistoria é criada somente no App.
    |
    | A Vistoria chega inicialmente ao servidor como:
    |
    | 2 = EM ANDAMENTO
    |
    | Depois que todos os Dados forem enviados pelo App,
    | o SyncService executará o UPDATE para:
    |
    | 3 = CONCLUÍDA
    |
    */

    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDAÇÃO
        |--------------------------------------------------------------------------
        */

        $dados = $request->validate([
            'cliente_id' => ['required', 'integer'],

            'edificacao_id' => ['required', 'integer'],

            'app_vistoria_sistema_status_id' => [
                'required',
                'integer',
                'in:2'
            ],

            'data_abertura' => ['nullable', 'string', 'max:10'],

            'hora_abertura' => ['nullable', 'string', 'max:8'],

            'data_prevista' => ['nullable', 'string', 'max:10'],

            'hora_prevista' => ['nullable', 'string', 'max:8'],

            'data_conclusao' => ['nullable', 'string', 'max:10'],

            'hora_conclusao' => ['nullable', 'string', 'max:8'],

            'responsavel_user_id' => ['nullable', 'integer'],

            'responsavel_user_nome' => [
                'nullable',
                'string',
                'max:255'
            ],

            'responsavel_user_email' => [
                'nullable',
                'string',
                'max:255'
            ],
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
        | VERIFICA IDEMPOTÊNCIA
        |--------------------------------------------------------------------------
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
        */

        try {

            $resposta = DB::transaction(function () use (
                $dados,
                $idOperacao
            ) {

                /*
                |--------------------------------------------------------------------------
                | EMPRESA
                |--------------------------------------------------------------------------
                |
                | A empresa é informada pelo App através do Header.
                |
                */

                $empresaId = request()->header('X-Empresa-Id');

                if (!$empresaId) {

                    return response()->json([
                        'message' => 'Empresa não informada.',
                    ], 422);
                }

                $empresaId = (int) $empresaId;


                /*
                |--------------------------------------------------------------------------
                | ANO
                |--------------------------------------------------------------------------
                */

                $ano = now()->year;


                /*
                |--------------------------------------------------------------------------
                | GERA NÚMERO DA VISTORIA
                |--------------------------------------------------------------------------
                |
                | O número é gerado pelo servidor.
                |
                | Exemplo:
                |
                | 000001
                | 000002
                | 000003
                |
                */

                $ultimoNumero = DB::table(
                    'app_vistorias_sistemas'
                )
                    ->where('ano_vistoria_sistema', $ano)
                    ->lockForUpdate()
                    ->max('numero_vistoria_sistema');


                if ($ultimoNumero) {

                    $numero = ((int) $ultimoNumero) + 1;

                } else {

                    $numero = 1;
                }


                /*
                |--------------------------------------------------------------------------
                | BUSCA CLIENTE
                |--------------------------------------------------------------------------
                |
                | Os campos derivados do cliente ficam no servidor.
                |
                */

                $cliente = DB::table('clientes')
                    ->where('id', $dados['cliente_id'])
                    ->first();


                /*
                |--------------------------------------------------------------------------
                | BUSCA EDIFICAÇÃO
                |--------------------------------------------------------------------------
                |
                | Os campos derivados da edificação também ficam
                | no servidor.
                |
                */

                $edificacao = DB::table('edificacoes')
                    ->where('id', $dados['edificacao_id'])
                    ->first();


                /*
                |--------------------------------------------------------------------------
                | MONTA REGISTRO
                |--------------------------------------------------------------------------
                */

                $registro = [

                    'empresa_id' =>
                        $empresaId,

                    'numero_vistoria_sistema' =>
                        $numero,

                    'ano_vistoria_sistema' =>
                        $ano,

                    /*
                    |--------------------------------------------------------------------------
                    | IMPORTANTE
                    |--------------------------------------------------------------------------
                    |
                    | A Vistoria entra no servidor como EM ANDAMENTO.
                    |
                    | O App enviará os Dados depois.
                    |
                    | Somente após os Dados serem sincronizados,
                    | o App executará o UPDATE para status 3.
                    |
                    */

                    'app_vistoria_sistema_status_id' =>
                        2,

                    'data_abertura' =>
                        $dados['data_abertura'] ?? null,

                    'hora_abertura' =>
                        $dados['hora_abertura'] ?? null,

                    'data_prevista' =>
                        $dados['data_prevista'] ?? null,

                    'hora_prevista' =>
                        $dados['hora_prevista'] ?? null,

                    /*
                    |--------------------------------------------------------------------------
                    | Ainda não está concluída.
                    |--------------------------------------------------------------------------
                    */

                    'data_conclusao' =>
                        null,

                    'hora_conclusao' =>
                        null,

                    'cliente_id' =>
                        $dados['cliente_id'],

                    'edificacao_id' =>
                        $dados['edificacao_id'],

                    'responsavel_user_id' =>
                        $dados['responsavel_user_id'] ?? null,

                    'responsavel_user_nome' =>
                        $dados['responsavel_user_nome'] ?? null,

                    'responsavel_user_email' =>
                        $dados['responsavel_user_email'] ?? null,

                    'created_at' =>
                        now(),

                    'updated_at' =>
                        now(),
                ];


                /*
                |--------------------------------------------------------------------------
                | CAMPOS DERIVADOS DO CLIENTE
                |--------------------------------------------------------------------------
                |
                | Aqui vamos preencher somente se essas colunas
                | existirem na versão atual da tabela.
                |
                */

                if ($cliente) {

                    if (array_key_exists(
                        'cliente_nome',
                        $this->colunasVistoria()
                    )) {

                        $registro['cliente_nome'] =
                            $cliente->nome ?? null;
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | CAMPOS DERIVADOS DA EDIFICAÇÃO
                |--------------------------------------------------------------------------
                */

                if ($edificacao) {

                    if (array_key_exists(
                        'edificacao_nome',
                        $this->colunasVistoria()
                    )) {

                        $registro['edificacao_nome'] =
                            $edificacao->nome ?? null;
                    }
                }







//                 // FALHA PROPOSITAL
//                 throw new \Exception(
//     'FALHA PROPOSITAL - TESTE INSERT VISTORIA'
// );



                /*
                |--------------------------------------------------------------------------
                | CRIA VISTORIA
                |--------------------------------------------------------------------------
                */

                $id = DB::table(
                    'app_vistorias_sistemas'
                )->insertGetId($registro);


                /*
                |--------------------------------------------------------------------------
                | BUSCA REGISTRO COMPLETO
                |--------------------------------------------------------------------------
                */

                $vistoria = DB::table(
                    'app_vistorias_sistemas'
                )
                    ->where('id', $id)
                    ->first();


                /*
                |--------------------------------------------------------------------------
                | REGISTRA OPERAÇÃO
                |--------------------------------------------------------------------------
                */

                AppOperacaoSincronizacao::create([
                    'id_operacao' =>
                        $idOperacao,

                    'tabela' =>
                        'app_vistorias_sistemas',

                    'registro_id' =>
                        $id,

                    'operacao' =>
                        'INSERT',

                    'resposta' =>
                        (array) $vistoria,
                ]);


                /*
                |--------------------------------------------------------------------------
                | RETORNA RESPOSTA
                |--------------------------------------------------------------------------
                */

                return (array) $vistoria;
            });


            
            return response()->json(
                $resposta,
                201
            );


        } catch (QueryException $e) {

            /*
            |--------------------------------------------------------------------------
            | CONCORRÊNCIA / UUID DUPLICADO
            |--------------------------------------------------------------------------
            */

            $codigoErro =
                $e->errorInfo[1] ?? null;

            $sqlState =
                $e->errorInfo[0] ?? null;

            $erroDuplicado =
                $codigoErro === 1062 ||
                $sqlState === '23000';


            if (!$erroDuplicado) {

                throw $e;
            }


            /*
            |--------------------------------------------------------------------------
            | RECUPERA OPERAÇÃO ORIGINAL
            |--------------------------------------------------------------------------
            */

            $operacaoExistente =
                AppOperacaoSincronizacao::where(
                    'id_operacao',
                    $idOperacao
                )->first();


            if (!$operacaoExistente) {

                throw $e;
            }


            return response()->json(
                $operacaoExistente->resposta,
                201
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    |
    | O servidor pode alterar uma Vistoria.
    |
    | Para alterações originadas pelo App, o SyncService
    | enviará X-Operacao-Id.
    |
    */

    public function update(
        Request $request,
        int $id
    ) {

        $dados = $request->validate([

            'app_vistoria_sistema_status_id' => [
                'required',
                'integer',
                'in:1,2,3,4,5'
            ],

            'data_abertura' => [
                'nullable',
                'string',
                'max:10'
            ],

            'hora_abertura' => [
                'nullable',
                'string',
                'max:8'
            ],

            'data_prevista' => [
                'nullable',
                'string',
                'max:10'
            ],

            'hora_prevista' => [
                'nullable',
                'string',
                'max:8'
            ],

            'data_conclusao' => [
                'nullable',
                'string',
                'max:10'
            ],

            'hora_conclusao' => [
                'nullable',
                'string',
                'max:8'
            ],

            'responsavel_user_id' => [
                'nullable',
                'integer'
            ],

            'responsavel_user_nome' => [
                'nullable',
                'string',
                'max:255'
            ],

            'responsavel_user_email' => [
                'nullable',
                'string',
                'max:255'
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | ID DA OPERAÇÃO
        |--------------------------------------------------------------------------
        */

        $idOperacao =
            $request->header('X-Operacao-Id');


        if (!$idOperacao) {

            return response()->json([
                'message' =>
                    'ID da operação não informado.',
            ], 400);
        }


        if (!Str::isUuid($idOperacao)) {

            return response()->json([
                'message' =>
                    'ID da operação inválido.',
            ], 400);
        }


        /*
        |--------------------------------------------------------------------------
        | IDEMPOTÊNCIA
        |--------------------------------------------------------------------------
        */

        $operacaoExistente =
            AppOperacaoSincronizacao::where(
                'id_operacao',
                $idOperacao
            )->first();


        if ($operacaoExistente) {

            return response()->json(
                $operacaoExistente->resposta
            );
        }


        /*
        |--------------------------------------------------------------------------
        | TRANSAÇÃO
        |--------------------------------------------------------------------------
        */

        try {

            $resposta = DB::transaction(
                function () use (
                    $dados,
                    $id,
                    $idOperacao
                ) {

                    $vistoria =
                        DB::table(
                            'app_vistorias_sistemas'
                        )
                        ->where('id', $id)
                        ->lockForUpdate()
                        ->first();


                    if (!$vistoria) {

                        abort(
                            404,
                            'Vistoria não encontrada.'
                        );
                    }





//                     throw new \Exception(
//     'FALHA PROPOSITAL - TESTE UPDATE VISTORIA'
// );



                    DB::table(
                        'app_vistorias_sistemas'
                    )
                    ->where('id', $id)
                    ->update([
                        ...$dados,
                        'updated_at' => now(),
                    ]);


                    $vistoriaAtualizada =
                        DB::table(
                            'app_vistorias_sistemas'
                        )
                        ->where('id', $id)
                        ->first();


                    AppOperacaoSincronizacao::create([
                        'id_operacao' =>
                            $idOperacao,

                        'tabela' =>
                            'app_vistorias_sistemas',

                        'registro_id' =>
                            $id,

                        'operacao' =>
                            'UPDATE',

                        'resposta' =>
                            (array) $vistoriaAtualizada,
                    ]);


                    return (array)
                        $vistoriaAtualizada;
                }
            );


            return response()->json(
                $resposta
            );


        } catch (QueryException $e) {

            $codigoErro =
                $e->errorInfo[1] ?? null;

            $sqlState =
                $e->errorInfo[0] ?? null;

            $erroDuplicado =
                $codigoErro === 1062 ||
                $sqlState === '23000';


            if (!$erroDuplicado) {

                throw $e;
            }


            $operacaoExistente =
                AppOperacaoSincronizacao::where(
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


    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    |
    | Uma Vistoria pode ser excluída pelo App depois
    | de já ter sido enviada ao servidor.
    |
    */

    public function delete(
        Request $request,
        int $id
    ) {

        $idOperacao =
            $request->header('X-Operacao-Id');


        if (!$idOperacao) {

            return response()->json([
                'message' =>
                    'ID da operação não informado.',
            ], 400);
        }


        if (!Str::isUuid($idOperacao)) {

            return response()->json([
                'message' =>
                    'ID da operação inválido.',
            ], 400);
        }


        /*
        |--------------------------------------------------------------------------
        | IDEMPOTÊNCIA
        |--------------------------------------------------------------------------
        */

        $operacaoExistente =
            AppOperacaoSincronizacao::where(
                'id_operacao',
                $idOperacao
            )->first();


        if ($operacaoExistente) {

            return response()->json(
                $operacaoExistente->resposta
            );
        }


        try {

            $resposta = DB::transaction(
                function () use (
                    $id,
                    $idOperacao
                ) {

                    $vistoria =
                        DB::table(
                            'app_vistorias_sistemas'
                        )
                        ->where('id', $id)
                        ->lockForUpdate()
                        ->first();


                    if (!$vistoria) {

                        abort(
                            404,
                            'Vistoria não encontrada.'
                        );
                    }


                    $resposta = [

                        'message' =>
                            'Vistoria excluída com sucesso.',

                        'id' =>
                            $id,
                    ];


                    DB::table(
                        'app_vistorias_sistemas'
                    )
                    ->where('id', $id)
                    ->delete();


                    AppOperacaoSincronizacao::create([
                        'id_operacao' =>
                            $idOperacao,

                        'tabela' =>
                            'app_vistorias_sistemas',

                        'registro_id' =>
                            $id,

                        'operacao' =>
                            'DELETE',

                        'resposta' =>
                            $resposta,
                    ]);


                    return $resposta;
                }
            );


            return response()->json(
                $resposta
            );


        } catch (QueryException $e) {

            $codigoErro =
                $e->errorInfo[1] ?? null;

            $sqlState =
                $e->errorInfo[0] ?? null;

            $erroDuplicado =
                $codigoErro === 1062 ||
                $sqlState === '23000';


            if (!$erroDuplicado) {

                throw $e;
            }


            $operacaoExistente =
                AppOperacaoSincronizacao::where(
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


    /*
    |--------------------------------------------------------------------------
    | COLUNAS DA TABELA
    |--------------------------------------------------------------------------
    |
    | Usado para evitar inserir campos derivados que eventualmente
    | não existam na versão atual da tabela.
    |
    */

    private function colunasVistoria(): array
    {
        return DB::getSchemaBuilder()->getColumnListing(
            'app_vistorias_sistemas'
        );
    }
}
