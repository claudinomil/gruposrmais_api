<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use App\Facades\Transacoes;
use App\Http\Requests\ClienteExecutivoStoreRequest;
use App\Http\Requests\ClienteExecutivoUpdateRequest;
use App\Models\Cliente;
use App\Models\ClienteExecutivo;
use App\Models\ClienteExecutivoDocumento;
use App\Models\Documento;
use App\Models\DocumentoFonte;
use App\Models\Estado;
use App\Models\Genero;
use App\Models\GrupoPermissao;
use App\Models\IdentidadeOrgao;
use App\Models\Nacionalidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteExecutivoController extends Controller
{
    private $cliente_executivo;

    public function __construct(ClienteExecutivo $cliente_executivo)
    {
        $this->cliente_executivo = $cliente_executivo;
    }

    public function index()
    {
        $registros = $this->cliente_executivo
            ->leftJoin('clientes', 'clientes_executivos.cliente_id', '=', 'clientes.id')
            ->select(['clientes_executivos.*', 'clientes.name as clienteName'])
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }

    public function show($id)
    {
        try {
            $registro = $this->cliente_executivo->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registro);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function auxiliary()
    {
        try {
            $registros = array();

            //Clientes
            $registros['clientes'] = Cliente::all();

            //Gêneros
            $registros['generos'] = Genero::all();

            //Nacionalidades
            $registros['nacionalidades'] = Nacionalidade::all();

            //Órgãos Identidades
            $registros['identidade_orgaos'] = IdentidadeOrgao::all();

            //Estados para a Identidade
            $registros['identidade_estados'] = Estado::all();

            //Documentos
            $registros['documentos'] = Documento
                ::join('documento_submodulos', 'documentos.documento_submodulo_id', 'documento_submodulos.id')
                ->join('documento_fontes', 'documentos.documento_fonte_id', 'documento_fontes.id')
                ->select('documentos.*', 'documento_submodulos.name as documentoSubmoduloName', 'documento_fontes.name as documentoFonteName')
                ->where('documentos.documento_submodulo_id', 3)
                ->orderby('documento_fontes.ordem', 'ASC')
                ->orderby('documentos.ordem', 'ASC')
                ->get();
                
            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function store(ClienteExecutivoStoreRequest $request)
    {
        try {
            //Incluindo registro
            $registro = $this->cliente_executivo->create($request->all());

            //Return
            return $this->sendResponse('Registro criado com sucesso.', 2010, null, null);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function update(ClienteExecutivoUpdateRequest $request, $id)
    {
        try {
            $registro = $this->cliente_executivo->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Alterando registro
                $registro->update($request->all());

                return $this->sendResponse('Registro atualizado com sucesso.', 2000, null, $registro);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function destroy($id)
    {
        try {
            $registro = $this->cliente_executivo->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, $registro);
            } else {
                //Verificar Relacionamentos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //Tabela ordens_servicos_executivos
                if (SuporteFacade::verificarRelacionamento('ordens_servicos_executivos', 'cliente_executivo_id', $id) > 0) {
                    return $this->sendResponse('Náo é possível excluir. Registro relacionado com Ordens Serviços Executivos.', 2040, null, null);
                }

                //Tabela clientes_executivos_documentos
                if (SuporteFacade::verificarRelacionamento('clientes_executivos_documentos', 'cliente_executivo_id', $id) > 0) {
                    return $this->sendResponse('Náo é possível excluir. Registro relacionado com Clientes Executivos Documentos.', 2040, null, null);
                }
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Apagar dados na tabela clientes_executivos_documentos''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                ClienteExecutivoDocumento::where('cliente_executivo_id', '=', $id)->delete();
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Deletar'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $registro->delete();

                return $this->sendResponse('Registro excluído com sucesso.', 2000, null, null);
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function filter($array_dados)
    {
        //Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        //Limpar Querys executadas
        //DB::enableQueryLog();


        //Registros
        $registros = $this->cliente_executivo
            ->leftJoin('clientes', 'clientes_executivos.cliente_id', '=', 'clientes.id')
            ->select(['clientes_executivos.*', 'clientes.name as clienteName'])
            ->where(function($query) use($filtros) {
                //Variavel para controle
                $qtdFiltros = count($filtros) / 4;
                $indexCampo = 0;

                for($i=1; $i<=$qtdFiltros; $i++) {
                    //Valores do Filtro
                    $condicao = $filtros[$indexCampo];
                    $campo = $filtros[$indexCampo+1];
                    $operacao = $filtros[$indexCampo+2];
                    $dado = $filtros[$indexCampo+3];

                    //Operações
                    if ($operacao == 1) {
                        if ($condicao == 1) {$query->where($campo, 'like', '%'.$dado.'%');} else {$query->orwhere($campo, 'like', '%'.$dado.'%');}
                    }
                    if ($operacao == 2) {
                        if ($condicao == 1) {$query->where($campo, '=', $dado);} else {$query->orwhere($campo, '=', $dado);}
                    }
                    if ($operacao == 3) {
                        if ($condicao == 1) {$query->where($campo, '>', $dado);} else {$query->orwhere($campo, '>', $dado);}
                    }
                    if ($operacao == 4) {
                        if ($condicao == 1) {$query->where($campo, '>=', $dado);} else {$query->orwhere($campo, '>=', $dado);}
                    }
                    if ($operacao == 5) {
                        if ($condicao == 1) {$query->where($campo, '<', $dado);} else {$query->orwhere($campo, '<', $dado);}
                    }
                    if ($operacao == 6) {
                        if ($condicao == 1) {$query->where($campo, '<=', $dado);} else {$query->orwhere($campo, '<=', $dado);}
                    }
                    if ($operacao == 7) {
                        if ($condicao == 1) {$query->where($campo, 'like', $dado.'%');} else {$query->orwhere($campo, 'like', $dado.'%');}
                    }
                    if ($operacao == 8) {
                        if ($condicao == 1) {$query->where($campo, 'like', '%'.$dado);} else {$query->orwhere($campo, 'like', '%'.$dado);}
                    }

                    //Atualizar indexCampo
                    $indexCampo = $indexCampo + 4;
                }
            }
            )->get();

        //Código SQL Bruto
        //$sql = DB::getQueryLog();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }

    // public function modal_info($id)
    // {
    //     try {
    //         $registro = array();

    //         //ClienteExecutivo
    //         $cliente_executivo = ClienteExecutivo
    //             ::leftJoin('generos', 'clientes_executivos.genero_id', '=', 'generos.id')
    //             ->select(['clientes_executivos.*', 'generos.name as generoName'])
    //             ->where('clientes_executivos.id', '=', $id)
    //             ->get();

    //         $registro['cliente_executivo'] = $cliente_executivo[0];

    //         return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registro);
    //     } catch (\Exception $e) {
    //         if (config('app.debug')) {
    //             return $this->sendResponse($e->getMessage(), 5000, null, null);
    //         }

    //         return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
    //     }
    // }

    // public function upload_foto(Request $request, $id)
    // {
    //     try {
    //         $registro = $this->cliente_executivo->find($id);

    //         if (!$registro) {
    //             return $this->sendResponse('Registro não encontrado.', 4040, null, null);
    //         } else {
    //             //Alterando registro
    //             $registro->update($request->all());

    //             //Transação
    //             $dadosAtual = array();
    //             $dadosAtual['name'] = $request['name'];
    //             $dadosAtual['foto'] = 'Foto atualizada';

    //             Transacoes::transacaoRecord(3, 2, 'clientes_executivos', $request, $dadosAtual);

    //             //Return
    //             return $this->sendResponse('Foto atualizada com sucesso.', 2000, null, $registro);
    //         }
    //     } catch (\Exception $e) {
    //         if (config('app.debug')) {
    //             return $this->sendResponse($e->getMessage(), 5000, null, null);
    //         }

    //         return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
    //     }
    // }

    // public function upload_documento(Request $request)
    // {
    //     try {
    //         //Incluir Registro
    //         if ($request['acao'] == 1) {
    //             //Registro
    //             ClienteExecutivoDocumento::create($request->all());

    //             //Transação
    //             Transacoes::transacaoRecord(2, 1, 'clientes_executivos', $request, $request);

    //             //Return
    //             return $this->sendResponse('Documento enviado com sucesso.', 2000, null, $request);
    //         }
    //     } catch (\Exception $e) {
    //         if (config('app.debug')) {
    //             return $this->sendResponse($e->getMessage(), 5000, null, null);
    //         }

    //         return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
    //     }
    // }

    // public function documentos($cliente_executivo_id)
    // {
    //     try {
    //         $registros = ClienteExecutivoDocumento
    //             ::where('cliente_executivo_id', $cliente_executivo_id)
    //             ->get();

    //         return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    //     } catch (\Exception $e) {
    //         if (config('app.debug')) {
    //             return $this->sendResponse($e->getMessage(), 5000, null, null);
    //         }

    //         return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
    //     }
    // }

    // public function deletar_documento($cliente_executivo_documento_id)
    // {
    //     $registro = ClienteExecutivoDocumento::find($cliente_executivo_documento_id);

    //     if (!$registro) {
    //         return $this->sendResponse('Documento não encontrado.', 4040, null, $registro);
    //     } else {
    //         //Deletar
    //         $registro->delete();

    //         //gravar transacao
    //         Transacoes::transacaoRecord(2, 3, 'clientes_executivos', $registro, $registro);

    //         //Return
    //         return $this->sendResponse('Documento excluído com sucesso.', 2000, null, $registro['caminho']);
    //     }
    // }


    public function modal_info($id)
    {
        try {
            $registro = array();

            //Cliente Executivo
            $cliente_executivo = ClienteExecutivo
                ::leftJoin('generos', 'clientes_executivos.genero_id', '=', 'generos.id')
                ->join('clientes', 'clientes_executivos.cliente_id', '=', 'clientes.id')
                ->select(['clientes_executivos.*', 'generos.name as generoName', 'clientes.name as clienteName'])
                ->where('clientes_executivos.id', '=', $id)
                ->get();
                
            $registro['cliente_executivo'] = $cliente_executivo[0];
            
            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registro);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function estatisticas($id)
    {
        try {
            $registro = array();

            //Documentos
            $documentos = ClienteExecutivoDocumento
                ::where('cliente_executivo_id', '=', $id)
                ->count();

            $registro['documentos'] = $documentos;
            
            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registro);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function upload_fotografia_documento(Request $request)
    {
        try {
            $registro = $this->cliente_executivo->find($request['cliente_executivo_id']);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Alterando registro
                $registro->fotografia_documento = $request['fotografia_documento'];
                $registro->save();

                return $this->sendResponse('Registro atualizado com sucesso.', 2000, null, $registro);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function upload_fotografia_cartao_emergencial(Request $request)
    {
        try {
            $registro = $this->cliente_executivo->find($request['cliente_executivo_id']);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Alterando registro
                $registro->fotografia_cartao_emergencial = $request['fotografia_cartao_emergencial'];
                $registro->save();

                return $this->sendResponse('Registro atualizado com sucesso.', 2000, null, $registro);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function upload_documento(Request $request)
    {
        try {
            //Incluir Registro
            if ($request['acao'] == 1) {
                //Registro
                ClienteExecutivoDocumento::create($request->all());

                //Transação
                Transacoes::transacaoRecord(2, 1, 'clientes_executivos', $request, $request);

                //Return
                return $this->sendResponse('Documento enviado com sucesso.', 2000, null, $request);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function documentos($cliente_executivo_id)
    {
        try {
            $registros = array();

            $registros['permissoes'] = GrupoPermissao
                ::join('permissoes', 'grupos_permissoes.permissao_id', '=', 'permissoes.id')
                ->select('permissoes.name as permissao')
                ->where('grupos_permissoes.grupo_id', Auth::user()->grupo_id)
                ->where('permissoes.name', 'like', 'clientes_executivos_%')
                ->get();

            $registros['documento_fontes'] = DocumentoFonte::orderby('ordem', 'ASC')->get();

            $registros['clientes_executivos_documentos'] = ClienteExecutivoDocumento
                ::join('documentos', 'clientes_executivos_documentos.documento_id', 'documentos.id')
                ->join('documento_submodulos', 'documentos.documento_submodulo_id', 'documento_submodulos.id')
                ->join('documento_fontes', 'documentos.documento_fonte_id', 'documento_fontes.id')
                ->select('clientes_executivos_documentos.*', 'documentos.documento_fonte_id', 'documentos.name as documentoName', 'documento_submodulos.name as documentoSubmoduloName', 'documento_fontes.name as documentoFonteName')
                ->where('clientes_executivos_documentos.cliente_executivo_id', $cliente_executivo_id)
                ->orderby('documento_fontes.ordem', 'ASC')
                ->orderby('documentos.ordem', 'ASC')
                ->get();

            return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function deletar_documento($cliente_executivo_documento_id)
    {
        $registro = ClienteExecutivoDocumento::find($cliente_executivo_documento_id);

        if (!$registro) {
            return $this->sendResponse('Documento não encontrado.', 4040, null, $registro);
        } else {
            //Deletar
            $registro->delete();

            //gravar transacao
            Transacoes::transacaoRecord(2, 3, 'clientes_executivos', $registro, $registro);

            //Return
            return $this->sendResponse('Documento excluído com sucesso.', 2000, null, $registro['caminho']);
        }
    }
    
    public function cartoes_emergenciais_registros()
    {
        $registros = $this->cliente_executivo->orderby('id')->get(['id']);

        return response()->json($registros, 200);
    }

    public function cartoes_emergenciais_dados($ids)
    {
        try {
            $ids = is_array($ids) ? $ids : explode(',', $ids);

            $registros = ClienteExecutivo
                ::leftJoin('generos', 'clientes_executivos.genero_id', '=', 'generos.id')
                ->leftJoin('clientes', 'clientes_executivos.cliente_id', '=', 'clientes.id')
                ->select(['clientes_executivos.*', 'generos.name as generoName', 'clientes.name as clienteName'])
                ->wherein('clientes_executivos.id', $ids)
                ->get();

            if (!$registros) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                return $this->sendResponse('Registros enviados com sucesso.', 2000, null, $registros);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }
}