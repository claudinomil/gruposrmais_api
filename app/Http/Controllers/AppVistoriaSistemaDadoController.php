<?php

namespace App\Http\Controllers;

use App\Models\AppVistoriaSistema;
use App\Models\AppVistoriaSistemaDado;
use App\Models\ClienteSistemaPreventivo;
use App\Models\SistemaPreventivo;
use App\Models\EdificacaoLocal;
use App\Models\EdificacaoNivel;
use App\Models\AppOperacaoSincronizacao;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class AppVistoriaSistemaDadoController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    |
    | Lista os dados de uma Vistoria.
    |
    | Exemplo:
    |
    | GET /api/app_vistorias_sistemas_dados?vistoria_id=123
    |
    */

    public function index(Request $request)
    {
        $request->validate([
            'app_vistoria_sistema_id' => [
                'required',
                'integer',
            ],
        ]);

        return response()->json([
            'ok' => true,
            'id' => $request->app_vistoria_sistema_id,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    |
    | Cria um novo dado da Vistoria.
    |
    */

    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validação
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'app_vistoria_sistema_id' => [
                'required',
                'integer',
                'exists:app_vistorias_sistemas,id'
            ],

            'cliente_sistema_preventivo_id' => [
                'required',
                'integer',
                'exists:clientes_sistemas_preventivos,id'
            ],

            'resposta' => [
                'nullable',
                'integer'
            ],

            'observacao' => [
                'nullable',
                'string'
            ],

            'fotografia_1' => [
                'nullable',
                'file',
                'image'
            ],

            'fotografia_2' => [
                'nullable',
                'file',
                'image'
            ],

            'fotografia_3' => [
                'nullable',
                'file',
                'image'
            ]
        ]);


        /*
        |--------------------------------------------------------------------------
        | Identificador da operação
        |--------------------------------------------------------------------------
        */

        $idOperacao = $request->header('X-Operacao-Id');

        if (!$idOperacao) {
            return response()->json([
                'message' => 'O header X-Operacao-Id é obrigatório.',
                'code' => 422,
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | Validação básica do UUID
        |--------------------------------------------------------------------------
        */

        if (!preg_match(
            '/^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[1-5][0-9a-fA-F]{3}-[89abAB][0-9a-fA-F]{3}-[0-9a-fA-F]{12}$/',
            $idOperacao
        )) {
            return response()->json([
                'message' => 'O X-Operacao-Id deve ser um UUID válido.',
                'code' => 422,
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | Verificação de idempotência
        |--------------------------------------------------------------------------
        */

        $operacaoExistente = AppOperacaoSincronizacao::where(
            'id_operacao',
            $idOperacao
        )->first();

        if ($operacaoExistente) {

            return response()->json(
                json_decode($operacaoExistente->resposta, true),
                $operacaoExistente->status_http
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Recupera a Vistoria
        |--------------------------------------------------------------------------
        */

        $vistoria = AppVistoriaSistema::findOrFail(
            $request->app_vistoria_sistema_id
        );


        /*
        |--------------------------------------------------------------------------
        | Regra de negócio
        |--------------------------------------------------------------------------
        */

        if (!in_array(
            $vistoria->app_vistoria_sistema_status_id,
            [1, 2]
        )) {
            return response()->json([
                'message' => 'A Vistoria não pode mais ser alterada.',
                'code' => 422,
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | Recupera o Cliente Sistema Preventivo
        |--------------------------------------------------------------------------
        */

        $clienteSistemaPreventivo =
            ClienteSistemaPreventivo::findOrFail(
                $request->cliente_sistema_preventivo_id
            );


        /*
        |--------------------------------------------------------------------------
        | Recupera o Sistema Preventivo
        |--------------------------------------------------------------------------
        */

        $sistemaPreventivo = SistemaPreventivo::findOrFail(
            $clienteSistemaPreventivo->sistema_preventivo_id
        );


        /*
        |--------------------------------------------------------------------------
        | Recupera o Local da Edificação
        |--------------------------------------------------------------------------
        */

        $edificacaoLocal = EdificacaoLocal::findOrFail(
            $clienteSistemaPreventivo->edificacao_local_id
        );


        /*
        |--------------------------------------------------------------------------
        | Recupera o Nível da Edificação
        |--------------------------------------------------------------------------
        */

        $edificacaoNivel = EdificacaoNivel::findOrFail(
            $edificacaoLocal->edificacao_nivel_id
        );


        /*
        |--------------------------------------------------------------------------
        | Monta os dados
        |--------------------------------------------------------------------------
        */

        $dados = [
            'app_vistoria_sistema_id' =>
            $request->app_vistoria_sistema_id,

            'cliente_sistema_preventivo_id' =>
            $clienteSistemaPreventivo->id,

            'sistema_preventivo_numero' =>
            $clienteSistemaPreventivo->sistema_preventivo_numero,

            'sistema_preventivo_id' =>
            $sistemaPreventivo->id,

            'sistema_preventivo_nome' =>
            $sistemaPreventivo->name,

            'edificacao_local_id' =>
            $edificacaoLocal->id,

            'edificacao_local_nome' =>
            $edificacaoLocal->name,

            'edificacao_nivel_id' =>
            $edificacaoNivel->id,

            'edificacao_nivel_nome' =>
            $edificacaoNivel->name,

            'resposta' =>
            $request->resposta,

            'observacao' =>
            $request->observacao,

            'fotografia_1' => null,

            'fotografia_2' => null,

            'fotografia_3' => null,
        ];


        /*
        |--------------------------------------------------------------------------
        | Arquivos criados durante a operação
        |--------------------------------------------------------------------------
        */

        $fotografiasCriadas = [];


        /*
        |--------------------------------------------------------------------------
        | Executa a operação dentro de uma transação
        |--------------------------------------------------------------------------
        */

        try {

            $resultado = DB::transaction(function () use (
                $dados,
                $idOperacao,
                $request,
                $vistoria,
                $clienteSistemaPreventivo,
                &$fotografiasCriadas
            ) {

                /*
                |--------------------------------------------------------------------------
                | Cria o registro
                |--------------------------------------------------------------------------
                */

                $registro =
                    AppVistoriaSistemaDado::create($dados);


                /*
                |--------------------------------------------------------------------------
                | Salva as fotografias
                |--------------------------------------------------------------------------
                */

                for ($numero = 1; $numero <= 3; $numero++) {

                    $campo = "fotografia_{$numero}";

                    if ($request->hasFile($campo)) {

                        $fotografia =
                            $this->prepararFotografia(
                                $request->file($campo),
                                $vistoria->id,
                                $clienteSistemaPreventivo->sistema_preventivo_numero,
                                $numero
                            );

                        $fotografiasCriadas[] =
                            $fotografia;

                        $this->finalizarFotografia(
                            $fotografia['caminho_temporario'],
                            $fotografia['caminho_final_fisico']
                        );

                        $registro->{$campo} =
                            $fotografia['caminho'];

                        $fotografiasCriadas[array_key_last($fotografiasCriadas)]['finalizado'] = true;
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | Salva o registro com as fotografias
                |--------------------------------------------------------------------------
                */

                $registro->save();


                /*
                |--------------------------------------------------------------------------
                | Monta a resposta
                |--------------------------------------------------------------------------
                */

                $resposta = [
                    'message' =>
                    'Dado da Vistoria criado com sucesso.',

                    'code' => 201,

                    'content' => $registro,
                ];


                /*
                |--------------------------------------------------------------------------
                | Registra operação de sincronização
                |--------------------------------------------------------------------------
                */

                AppOperacaoSincronizacao::create([
                    'id_operacao' => $idOperacao,

                    'tabela' =>
                    'app_vistorias_sistemas_dados',

                    'registro_id' =>
                    $registro->id,

                    'operacao' =>
                    'INSERT',

                    'status_http' => 201,

                    'resposta' =>
                    json_encode($resposta),
                ]);


                return $resposta;
            });


            /*
            |--------------------------------------------------------------------------
            | Operação concluída
            |--------------------------------------------------------------------------
            */

            return response()->json(
                $resultado,
                201
            );
        } catch (\Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | Limpa fotografias criadas
            |--------------------------------------------------------------------------
            */

            foreach ($fotografiasCriadas as $fotografia) {

                if (!empty($fotografia['caminho_temporario'])) {

                    $this->excluirArquivoFisico(
                        $fotografia['caminho_temporario']
                    );
                }

                if (!empty($fotografia['caminho_final_fisico'])) {

                    $this->excluirArquivoFisico(
                        $fotografia['caminho_final_fisico']
                    );
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Tratamento de corrida de idempotência
            |--------------------------------------------------------------------------
            */

            if (
                $e instanceof QueryException &&
                (
                    $e->getCode() === '23000' ||
                    str_contains(
                        $e->getMessage(),
                        '1062'
                    )
                )
            ) {

                $operacaoExistente =
                    AppOperacaoSincronizacao::where(
                        'id_operacao',
                        $idOperacao
                    )->first();

                if ($operacaoExistente) {

                    return response()->json(
                        json_decode(
                            $operacaoExistente->resposta,
                            true
                        ),
                        $operacaoExistente->status_http
                    );
                }
            }


            throw $e;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    |
    | Atualiza um dado já existente.
    |
    */

    public function update(Request $request, $id)
    {
        /*
        |--------------------------------------------------------------------------
        | Validação
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'resposta' => [
                'nullable',
                'integer'
            ],

            'observacao' => [
                'nullable',
                'string'
            ],

            'fotografia_1' => [
                'nullable',
                'file',
                'image'
            ],

            'fotografia_2' => [
                'nullable',
                'file',
                'image'
            ],

            'fotografia_3' => [
                'nullable',
                'file',
                'image'
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | X-Operacao-Id
        |--------------------------------------------------------------------------
        */

        $idOperacao = $request->header('X-Operacao-Id');

        if (!$idOperacao) {
            return response()->json([
                'message' => 'O header X-Operacao-Id é obrigatório.',
                'code' => 422,
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | Validação básica do UUID
        |--------------------------------------------------------------------------
        */

        if (!preg_match(
            '/^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[1-5][0-9a-fA-F]{3}-[89abAB][0-9a-fA-F]{3}-[0-9a-fA-F]{12}$/',
            $idOperacao
        )) {
            return response()->json([
                'message' => 'O X-Operacao-Id deve ser um UUID válido.',
                'code' => 422,
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | Idempotência
        |--------------------------------------------------------------------------
        */

        $operacaoExistente =
            AppOperacaoSincronizacao::where(
                'id_operacao',
                $idOperacao
            )->first();

        if ($operacaoExistente) {

            return response()->json(
                json_decode(
                    $operacaoExistente->resposta,
                    true
                ),
                $operacaoExistente->status_http
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Recupera o registro
        |--------------------------------------------------------------------------
        */

        $registro =
            AppVistoriaSistemaDado::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Recupera a Vistoria pai
        |--------------------------------------------------------------------------
        */

        $vistoria =
            AppVistoriaSistema::findOrFail(
                $registro->app_vistoria_sistema_id
            );


        /*
        |--------------------------------------------------------------------------
        | Regra de negócio
        |--------------------------------------------------------------------------
        */

        if (!in_array(
            $vistoria->app_vistoria_sistema_status_id,
            [1, 2]
        )) {
            return response()->json([
                'message' => 'A Vistoria não pode mais ser alterada.',
                'code' => 422,
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | Recupera o Sistema Preventivo
        |--------------------------------------------------------------------------
        */

        $sistemaPreventivo =
            SistemaPreventivo::findOrFail(
                $registro->sistema_preventivo_id
            );


        /*
        |--------------------------------------------------------------------------
        | Recupera o Cliente Sistema Preventivo
        |--------------------------------------------------------------------------
        */

        $clienteSistemaPreventivo =
            ClienteSistemaPreventivo::findOrFail(
                $registro->cliente_sistema_preventivo_id
            );


        /*
        |--------------------------------------------------------------------------
        | Guarda as fotografias antigas
        |--------------------------------------------------------------------------
        */

        $fotografiasAntigas = [
            1 => $registro->fotografia_1,
            2 => $registro->fotografia_2,
            3 => $registro->fotografia_3,
        ];


        /*
        |--------------------------------------------------------------------------
        | Arquivos criados durante a operação
        |--------------------------------------------------------------------------
        */

        $fotografiasCriadas = [];


        /*
        |--------------------------------------------------------------------------
        | Executa UPDATE
        |--------------------------------------------------------------------------
        */

        try {

            $resultado = DB::transaction(function () use (
                $registro,
                $request,
                $idOperacao,
                $vistoria,
                $clienteSistemaPreventivo,
                $fotografiasAntigas,
                &$fotografiasCriadas
            ) {

                /*
                |--------------------------------------------------------------------------
                | Atualiza campos do App
                |--------------------------------------------------------------------------
                */

                $registro->resposta =
                    $request->resposta;

                $registro->observacao =
                    $request->observacao;


                /*
                |--------------------------------------------------------------------------
                | Fotografias
                |--------------------------------------------------------------------------
                */

                for ($numero = 1; $numero <= 3; $numero++) {

                    $campo =
                        "fotografia_{$numero}";

                    if ($request->hasFile($campo)) {

                        $fotografia =
                            $this->prepararFotografia(
                                $request->file($campo),
                                $vistoria->id,
                                $clienteSistemaPreventivo->sistema_preventivo_numero,
                                $numero
                            );

                        $fotografiasCriadas[$numero] =
                            $fotografia;


                        /*
                        |--------------------------------------------------------------------------
                        | Se já existe fotografia com o mesmo nome final,
                        | fazemos backup antes da substituição.
                        |--------------------------------------------------------------------------
                        */

                        if (
                            file_exists(
                                $fotografia['caminho_final_fisico']
                            )
                        ) {

                            $backup =
                                $fotografia['caminho_final_fisico']
                                . '.backup_'
                                . uniqid('', true);

                            if (
                                !rename(
                                    $fotografia['caminho_final_fisico'],
                                    $backup
                                )
                            ) {

                                throw new \RuntimeException(
                                    "Não foi possível preservar a fotografia {$numero} anterior."
                                );
                            }

                            $fotografiasCriadas[$numero]['backup'] =
                                $backup;
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Move a nova fotografia para o nome definitivo
                        |--------------------------------------------------------------------------
                        */

                        $this->finalizarFotografia(
                            $fotografia['caminho_temporario'],
                            $fotografia['caminho_final_fisico']
                        );


                        $fotografiasCriadas[$numero]['finalizado'] =
                            true;


                        /*
                        |--------------------------------------------------------------------------
                        | Atualiza o caminho no banco
                        |--------------------------------------------------------------------------
                        */

                        $registro->{$campo} =
                            $fotografia['caminho'];
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | Salva registro
                |--------------------------------------------------------------------------
                */

                $registro->save();


                /*
                |--------------------------------------------------------------------------
                | Resposta
                |--------------------------------------------------------------------------
                */

                $resposta = [
                    'message' =>
                    'Dado da Vistoria atualizado com sucesso.',

                    'code' => 200,

                    'content' => $registro,
                ];


                /*
                |--------------------------------------------------------------------------
                | Registra operação
                |--------------------------------------------------------------------------
                */

                AppOperacaoSincronizacao::create([
                    'id_operacao' => $idOperacao,

                    'tabela' =>
                    'app_vistorias_sistemas_dados',

                    'registro_id' =>
                    $registro->id,

                    'operacao' =>
                    'UPDATE',

                    'status_http' => 200,

                    'resposta' =>
                    json_encode($resposta),
                ]);


                return $resposta;
            });


            /*
            |--------------------------------------------------------------------------
            | Transação concluída.
            |
            | Agora podemos remover os backups das fotografias antigas.
            |--------------------------------------------------------------------------
            */

            foreach ($fotografiasCriadas as $fotografia) {

                if (!empty($fotografia['backup'])) {

                    $this->excluirArquivoFisico(
                        $fotografia['backup']
                    );
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Operação concluída
            |--------------------------------------------------------------------------
            */

            return response()->json(
                $resultado,
                200
            );
        } catch (\Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | Restaura fotografias antigas
            |--------------------------------------------------------------------------
            */

            foreach ($fotografiasCriadas as $numero => $fotografia) {

                /*
                |--------------------------------------------------------------------------
                | Remove fotografia nova
                |--------------------------------------------------------------------------
                */

                if (
                    !empty($fotografia['caminho_final_fisico'])
                ) {

                    $this->excluirArquivoFisico(
                        $fotografia['caminho_final_fisico']
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | Remove temporário, caso ainda exista
                |--------------------------------------------------------------------------
                */

                if (
                    !empty($fotografia['caminho_temporario'])
                ) {

                    $this->excluirArquivoFisico(
                        $fotografia['caminho_temporario']
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | Restaura backup
                |--------------------------------------------------------------------------
                */

                if (
                    !empty($fotografia['backup']) &&
                    file_exists($fotografia['backup'])
                ) {

                    rename(
                        $fotografia['backup'],
                        $fotografia['caminho_final_fisico']
                    );
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Tratamento de corrida de idempotência
            |--------------------------------------------------------------------------
            */

            if (
                $e instanceof QueryException &&
                (
                    $e->getCode() === '23000' ||
                    str_contains(
                        $e->getMessage(),
                        '1062'
                    )
                )
            ) {

                $operacaoExistente =
                    AppOperacaoSincronizacao::where(
                        'id_operacao',
                        $idOperacao
                    )->first();

                if ($operacaoExistente) {

                    return response()->json(
                        json_decode(
                            $operacaoExistente->resposta,
                            true
                        ),
                        $operacaoExistente->status_http
                    );
                }
            }


            throw $e;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    |
    | Exclui um dado da Vistoria.
    |
    */

    public function delete(Request $request, $id)
    {
        /*
        |--------------------------------------------------------------------------
        | X-Operacao-Id
        |--------------------------------------------------------------------------
        */

        $idOperacao = $request->header('X-Operacao-Id');

        if (!$idOperacao) {
            return response()->json([
                'message' => 'O header X-Operacao-Id é obrigatório.',
                'code' => 422,
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | Validação básica do UUID
        |--------------------------------------------------------------------------
        */

        if (!preg_match(
            '/^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[1-5][0-9a-fA-F]{3}-[89abAB][0-9a-fA-F]{3}-[0-9a-fA-F]{12}$/',
            $idOperacao
        )) {
            return response()->json([
                'message' => 'O X-Operacao-Id deve ser um UUID válido.',
                'code' => 422,
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | Idempotência
        |--------------------------------------------------------------------------
        */

        $operacaoExistente =
            AppOperacaoSincronizacao::where(
                'id_operacao',
                $idOperacao
            )->first();

        if ($operacaoExistente) {

            return response()->json(
                json_decode(
                    $operacaoExistente->resposta,
                    true
                ),
                $operacaoExistente->status_http
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Recupera registro
        |--------------------------------------------------------------------------
        */

        $registro =
            AppVistoriaSistemaDado::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Recupera Vistoria pai
        |--------------------------------------------------------------------------
        */

        $vistoria =
            AppVistoriaSistema::findOrFail(
                $registro->app_vistoria_sistema_id
            );


        /*
        |--------------------------------------------------------------------------
        | Regra de negócio
        |--------------------------------------------------------------------------
        */

        if (!in_array(
            $vistoria->app_vistoria_sistema_status_id,
            [1, 2]
        )) {
            return response()->json([
                'message' => 'A Vistoria não pode mais ser alterada.',
                'code' => 422,
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | DELETE
        |--------------------------------------------------------------------------
        */

        try {

            $resultado = DB::transaction(function () use (
                $registro,
                $idOperacao
            ) {

                $registroId =
                    $registro->id;


                /*
                |--------------------------------------------------------------------------
                | Exclui registro
                |--------------------------------------------------------------------------
                */

                $registro->delete();


                /*
                |--------------------------------------------------------------------------
                | Resposta
                |--------------------------------------------------------------------------
                */

                $resposta = [
                    'message' =>
                    'Dado da Vistoria excluído com sucesso.',

                    'code' => 200,

                    'content' => [
                        'id' => $registroId
                    ],
                ];


                /*
                |--------------------------------------------------------------------------
                | Registra operação
                |--------------------------------------------------------------------------
                */

                AppOperacaoSincronizacao::create([
                    'id_operacao' => $idOperacao,

                    'tabela' =>
                    'app_vistorias_sistemas_dados',

                    'registro_id' =>
                    $registroId,

                    'operacao' =>
                    'DELETE',

                    'status_http' => 200,

                    'resposta' =>
                    json_encode($resposta),
                ]);


                return $resposta;
            });


            return response()->json(
                $resultado,
                200
            );
        } catch (QueryException $e) {

            /*
            |--------------------------------------------------------------------------
            | Corrida de idempotência
            |--------------------------------------------------------------------------
            */

            if (
                $e->getCode() === '23000' ||
                str_contains(
                    $e->getMessage(),
                    '1062'
                )
            ) {

                $operacaoExistente =
                    AppOperacaoSincronizacao::where(
                        'id_operacao',
                        $idOperacao
                    )->first();

                if ($operacaoExistente) {

                    return response()->json(
                        json_decode(
                            $operacaoExistente->resposta,
                            true
                        ),
                        $operacaoExistente->status_http
                    );
                }
            }


            throw $e;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | PREPARAR FOTOGRAFIA
    |--------------------------------------------------------------------------
    |
    | Recebe o upload e cria um arquivo temporário.
    |
    */

    private function prepararFotografia(
        $arquivo,
        int $vistoriaId,
        string $sistemaPreventivoNumero,
        int $numero
    ): array {
        if (!$arquivo || !$arquivo->isValid()) {
            throw new \RuntimeException(
                "A fotografia {$numero} é inválida."
            );
        }


        $diretorio =
            base_path(
                '../gruposrmais-client/public/build/assets/images/vistorias_sistemas'
            );


        if (!is_dir($diretorio)) {

            if (
                !mkdir(
                    $diretorio,
                    0755,
                    true
                ) &&
                !is_dir($diretorio)
            ) {
                throw new \RuntimeException(
                    'Não foi possível criar o diretório das fotografias.'
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Extensão original
        |--------------------------------------------------------------------------
        */

        $extensao = strtolower(
            $arquivo->getClientOriginalExtension()
        );


        if (!$extensao) {
            $extensao = 'jpg';
        }


        /*
        |--------------------------------------------------------------------------
        | Nome definitivo
        |--------------------------------------------------------------------------
        |
        | Formato:
        |
        | vistoria_sistema_{id}_spn_{numero}_image_{num}.ext
        |
        */

        $nomeArquivo =
            "vistoria_sistema_{$vistoriaId}_spn_{$sistemaPreventivoNumero}_image_{$numero}.{$extensao}";


        /*
        |--------------------------------------------------------------------------
        | Nome temporário
        |--------------------------------------------------------------------------
        */

        $nomeTemporario =
            'tmp_vistoria_sistema_'
            . $vistoriaId
            . '_spn_'
            . $sistemaPreventivoNumero
            . '_image_'
            . $numero
            . '_'
            . uniqid('', true)
            . '.'
            . $extensao;


        $caminhoTemporario =
            $diretorio
            . DIRECTORY_SEPARATOR
            . $nomeTemporario;


        $caminhoFinalFisico =
            $diretorio
            . DIRECTORY_SEPARATOR
            . $nomeArquivo;


        /*
        |--------------------------------------------------------------------------
        | Move upload para temporário
        |--------------------------------------------------------------------------
        */

        $arquivo->move(
            $diretorio,
            $nomeTemporario
        );


        /*
        |--------------------------------------------------------------------------
        | Verifica se foi criado
        |--------------------------------------------------------------------------
        */

        if (!file_exists($caminhoTemporario)) {
            throw new \RuntimeException(
                "Não foi possível salvar temporariamente a fotografia {$numero}."
            );
        }


        return [
            'caminho' =>
            "vistorias_sistemas/{$nomeArquivo}",

            'caminho_temporario' =>
            $caminhoTemporario,

            'caminho_final' =>
            "vistorias_sistemas/{$nomeArquivo}",

            'caminho_final_fisico' =>
            $caminhoFinalFisico,

            'nome_arquivo' =>
            $nomeArquivo,

            'nome_temporario' =>
            $nomeTemporario,

            'extensao' =>
            $extensao,
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | FINALIZAR FOTOGRAFIA
    |--------------------------------------------------------------------------
    */

    private function finalizarFotografia(
        string $caminhoTemporario,
        string $caminhoFinal
    ): void {
        if (!file_exists($caminhoTemporario)) {
            throw new \RuntimeException(
                'O arquivo temporário da fotografia não foi encontrado.'
            );
        }


        if (file_exists($caminhoFinal)) {
            unlink($caminhoFinal);
        }


        if (!rename(
            $caminhoTemporario,
            $caminhoFinal
        )) {
            throw new \RuntimeException(
                'Não foi possível finalizar a fotografia.'
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | EXCLUIR FOTOGRAFIA
    |--------------------------------------------------------------------------
    */

    private function excluirFotografia(?string $caminho): void
    {
        if (!$caminho) {
            return;
        }


        $caminhoCompleto =
            base_path(
                '../gruposrmais-client/public/build/assets/images/'
                    . $caminho
            );


        if (file_exists($caminhoCompleto)) {
            unlink($caminhoCompleto);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | EXCLUIR ARQUIVO FÍSICO
    |--------------------------------------------------------------------------
    */

    private function excluirArquivoFisico(
        ?string $caminho
    ): void {
        if (!$caminho) {
            return;
        }


        if (file_exists($caminho)) {
            unlink($caminho);
        }
    }
}
