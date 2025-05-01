<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use App\Http\Requests\GrupoStoreRequest;
use App\Http\Requests\GrupoUpdateRequest;
use App\Models\GrupoPermissao;
use App\Models\GrupoRelatorio;
use App\Models\Permissao;
use App\Models\Relatorio;
use App\Models\Submodulo;
use Illuminate\Support\Facades\DB;
use App\Models\Grupo;

class GrupoController extends Controller
{
    private $grupo;

    public function __construct(Grupo $grupo)
    {
        $this->grupo = $grupo;
    }

    public function index($empresa_id)
    {
        //Registros
        $registros = array();

        //Varrendo Grupos para pegar Permissoes
        $grupos = $this->grupo->where('empresa_id', '=', $empresa_id)->get();
        foreach ($grupos as $key => $grupo) {
            $grupo_id = $grupo->id;
            $grupo_name = $grupo->name;

            $permissoes = "<div class='row'>";

            //Varrendo Submodulos para pegar Permissoes por submodulos
            $submodulos = Submodulo::all();
            foreach ($submodulos as $key => $submodulo) {
                $submodulo_id = $submodulo->id;
                $submodulo_name = $submodulo->name;

                //Buscando Permissoes
                $dados = DB::table('grupos_permissoes')
                    ->join('grupos', 'grupos.id', '=', 'grupos_permissoes.grupo_id')
                    ->leftJoin('permissoes', 'permissoes.id', '=', 'grupos_permissoes.permissao_id')
                    ->select(['permissoes.name as permissaoName'])
                    ->where('grupos_permissoes.grupo_id', $grupo_id)
                    ->where('permissoes.submodulo_id', $submodulo_id)
                    ->get();

                $permissoesSubmodulo = "<div class='col-12 col-md-3 pb-3'>";
                $permissoesSubmodulo .= "<b class='pb-3'>".$submodulo_name."</b>";

                $ctrl = 0;
                foreach ($dados as $key => $dado) {
                    $ctrl++;

                    $p = explode('_', $dado->permissaoName);
                    $p = $p[count($p)-1];

                    if ($p == 'list') {$perm = "<div class='col-12'><label class='form-check-label'><i class='fa fa-check text-primary'></i> Listar</label></div>";}
                    if ($p == 'show') {$perm = "<div class='col-12'><label class='form-check-label'><i class='fa fa-check text-info'></i> Mostrar</label></div>";}
                    if ($p == 'create') {$perm = "<div class='col-12'><label class='form-check-label'><i class='fa fa-check text-success'></i> Criar</label></div>";}
                    if ($p == 'edit') {$perm = "<div class='col-12'><label class='form-check-label'><i class='fa fa-check text-warning'></i> Editar</label></div>";}
                    if ($p == 'destroy') {$perm = "<div class='col-12'><label class='form-check-label'><i class='fa fa-check text-danger'></i> Deletar</label></div>";}

                    $permissoesSubmodulo .= $perm;
                }

                $permissoesSubmodulo .= "</div>";

                if ($ctrl > 0) {$permissoes .= $permissoesSubmodulo;}
            }

            $permissoes .= "</div>";

            //Montando registros de retorno
            $registros[] = [
                'id' => $grupo_id,
                'name' => $grupo_name,
                'permissoes' => $permissoes
            ];
        }

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $registros);
    }

    public function show($id)
    {
        try {
            //Buscando registro (Vem com Permissoes)
            $dados = DB::table('grupos')
                ->leftJoin('grupos_permissoes', 'grupos_permissoes.grupo_id', '=', 'grupos.id')
                ->leftJoin('permissoes', 'permissoes.id', '=', 'grupos_permissoes.permissao_id')
                ->select(['grupos.*', 'permissoes.name as permissaoName'])
                ->where('grupos.id', $id)
                ->get();

            //Montar registro para retorno
            $registro = array();

            $registro['id'] = $dados[0]->id; //Guarda id do Grupo
            $registro['name'] = $dados[0]->name; //Guarda name do Grupo

            foreach ($dados as $key => $dado) {
                $registro[$dado->permissaoName] = true; //Guarda nome das Permissoes do Grupo
            }

            //relatorios
            $registro['relatorios'] = GrupoRelatorio::where('grupo_id', $dados[0]->id)->get();

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

    public function auxiliary($empresa_id)
    {
        try {
            $registros = array();

            //Submódulos
            $registros['submodulos'] = Submodulo::all();

            //Permissões
            $registros['permissoes'] = Permissao::all();

            //Relatorios
            $registros['relatorios'] = Relatorio::select('relatorios.*', 'agrupamentos.name as relatorio_agrupamento')->join('agrupamentos', 'agrupamentos.id', 'relatorios.agrupamento_id')->orderby('agrupamentos.ordem_visualizacao')->orderby('relatorios.ordem_visualizacao')->get();

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function store(GrupoStoreRequest $request, $empresa_id)
    {
        try {
            //Atualisar objeto Auth::user()
            SuporteFacade::setUserLogged($empresa_id);

            //Colocar empresa_id no Request
            $request['empresa_id'] = $empresa_id;

            //Incluindo registro na tabela grupos
            $grupo = $this->grupo->create($request->all());
            $grupo_id = $grupo['id'];

            //Incluindo registros na tabela grupos_permissoes
            for($i=1; $i<=100; $i++) {
                if (isset($request['listar_'.$i])) {
                    $id = Permissao::where('name', $request['listar_'.$i])->get();
                    if (isset($id[0]['id'])) {
                        $permissao_id = $id[0]['id'];
                        GrupoPermissao::create(['grupo_id' => $grupo_id, 'permissao_id' => $permissao_id]);
                    }
                }

                if (isset($request['mostrar_'.$i])) {
                    $id = Permissao::where('name', $request['mostrar_'.$i])->get();
                    if (isset($id[0]['id'])) {
                        $permissao_id = $id[0]['id'];
                        GrupoPermissao::create(['grupo_id' => $grupo_id, 'permissao_id' => $permissao_id]);
                    }
                }

                if (isset($request['criar_'.$i])) {
                    $id = Permissao::where('name', $request['criar_'.$i])->get();
                    if (isset($id[0]['id'])) {
                        $permissao_id = $id[0]['id'];
                        GrupoPermissao::create(['grupo_id' => $grupo_id, 'permissao_id' => $permissao_id]);
                    }
                }

                if (isset($request['editar_'.$i])) {
                    $id = Permissao::where('name', $request['editar_'.$i])->get();
                    if (isset($id[0]['id'])) {
                        $permissao_id = $id[0]['id'];
                        GrupoPermissao::create(['grupo_id' => $grupo_id, 'permissao_id' => $permissao_id]);
                    }
                }

                if (isset($request['deletar_'.$i])) {
                    $id = Permissao::where('name', $request['deletar_'.$i])->get();
                    if (isset($id[0]['id'])) {
                        $permissao_id = $id[0]['id'];
                        GrupoPermissao::create(['grupo_id' => $grupo_id, 'permissao_id' => $permissao_id]);
                    }
                }
            }

            //Incluindo registros na tabela grupos_relatorios
            for($i=1; $i<=100; $i++) {
                if (isset($request['relatorio_'.$i])) {
                    GrupoRelatorio::create(['grupo_id' => $grupo_id, 'relatorio_id' => $i]);
                }
            }

            return $this->sendResponse('Registro criado com sucesso.', 2010, null, null);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function update(GrupoUpdateRequest $request, $id, $empresa_id)
    {
        try {
            $registro = $this->grupo->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, '', $registro);
            } else {
                //Atualisar objeto Auth::user()
                SuporteFacade::setUserLogged($empresa_id);

                //Alterando registro na tabela grupos
                $registro->update($request->all());

                $grupo_id = $id;

                //Deletando registros na tabela grupoPermissoes
                GrupoPermissao::where('grupo_id', $grupo_id)->delete();

                //Incluindo registros na tabela grupos_permissoes
                for($i=1; $i<=100; $i++) {
                    if (isset($request['listar_'.$i])) {
                        $id = Permissao::where('name', $request['listar_'.$i])->get();
                        if (isset($id[0]['id'])) {
                            $permissao_id = $id[0]['id'];
                            GrupoPermissao::create(['grupo_id' => $grupo_id, 'permissao_id' => $permissao_id]);
                        }
                    }

                    if (isset($request['mostrar_'.$i])) {
                        $id = Permissao::where('name', $request['mostrar_'.$i])->get();
                        if (isset($id[0]['id'])) {
                            $permissao_id = $id[0]['id'];
                            GrupoPermissao::create(['grupo_id' => $grupo_id, 'permissao_id' => $permissao_id]);
                        }
                    }

                    if (isset($request['criar_'.$i])) {
                        $id = Permissao::where('name', $request['criar_'.$i])->get();
                        if (isset($id[0]['id'])) {
                            $permissao_id = $id[0]['id'];
                            GrupoPermissao::create(['grupo_id' => $grupo_id, 'permissao_id' => $permissao_id]);
                        }
                    }

                    if (isset($request['editar_'.$i])) {
                        $id = Permissao::where('name', $request['editar_'.$i])->get();
                        if (isset($id[0]['id'])) {
                            $permissao_id = $id[0]['id'];
                            GrupoPermissao::create(['grupo_id' => $grupo_id, 'permissao_id' => $permissao_id]);
                        }
                    }

                    if (isset($request['deletar_'.$i])) {
                        $id = Permissao::where('name', $request['deletar_'.$i])->get();
                        if (isset($id[0]['id'])) {
                            $permissao_id = $id[0]['id'];
                            GrupoPermissao::create(['grupo_id' => $grupo_id, 'permissao_id' => $permissao_id]);
                        }
                    }
                }

                //Deletando registros na tabela grupos_relatorios
                GrupoRelatorio::where('grupo_id', $grupo_id)->delete();

                //Incluindo registros na tabela grupos_relatorios
                for($i=1; $i<=100; $i++) {
                    if (isset($request['relatorio_'.$i])) {
                        GrupoRelatorio::create(['grupo_id' => $grupo_id, 'relatorio_id' => $i]);
                    }
                }

                return $this->sendResponse('Registro atualizado com sucesso.', 2000, null, $registro);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function destroy($id, $empresa_id)
    {
        try {
            $registro = $this->grupo->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, $registro);
            } else {
                //Atualisar objeto Auth::user()
                SuporteFacade::setUserLogged($empresa_id);

                //Verificar Relacionamentos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //Tabela users_configuracoes
                if (SuporteFacade::verificarRelacionamento('users_configuracoes', 'grupo_id', $id) > 0) {
                    return $this->sendResponse('Náo é possível excluir. Registro relacionado com Usuários Configurações.', 2040, null, null);
                }
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Deletar'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //Deletar antes na tabela grupopermissoes
                DB::table('grupos_permissoes')->where('grupo_id', $id)->delete();

                //Deletar antes na tabela grupos_relatorios
                DB::table('grupos_relatorios')->where('grupo_id', $id)->delete();

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

//    public function search($field, $value, $empresa_id)
//    {
//        //Registros
//        $registros = array();
//
//        //Varrendo Grupos para pegar Permissoes
//        $grupos = $this->grupo->where('empresa_id', '=', $empresa_id)->where($field, 'like', '%'.$value.'%')->get();
//        foreach ($grupos as $key => $grupo) {
//            $grupo_id = $grupo->id;
//            $grupo_name = $grupo->name;
//
//            $permissoes = "<div class='row'>";
//
//            //Varrendo Submodulos para pegar Permissoes por submodulos
//            $submodulos = Submodulo::all();
//            foreach ($submodulos as $key => $submodulo) {
//                $submodulo_id = $submodulo->id;
//                $submodulo_name = $submodulo->name;
//
//                //Buscando Permissoes
//                $dados = DB::table('grupos_permissoes')
//                    ->leftJoin('permissoes', 'permissoes.id', '=', 'grupos_permissoes.permissao_id')
//                    ->select(['permissoes.name as permissaoName'])
//                    ->where('grupos_permissoes.grupo_id', $grupo_id)
//                    ->where('permissoes.submodulo_id', $submodulo_id)
//                    ->get();
//
//                $permissoesSubmodulo = "<div class='col-12 col-md-3 pb-3'>";
//                $permissoesSubmodulo .= "<b class='pb-3'>".$submodulo_name."</b>";
//
//                $ctrl = 0;
//                foreach ($dados as $key => $dado) {
//                    $ctrl++;
//
//                    $p = explode('_', $dado->permissaoName);
//                    $p = $p[count($p)-1];
//
//                    if ($p == 'list') {$perm = "<div class='col-12'><label class='form-check-label'><i class='fa fa-check text-primary'></i> Listar</label></div>";}
//                    if ($p == 'show') {$perm = "<div class='col-12'><label class='form-check-label'><i class='fa fa-check text-info'></i> Mostrar</label></div>";}
//                    if ($p == 'create') {$perm = "<div class='col-12'><label class='form-check-label'><i class='fa fa-check text-success'></i> Criar</label></div>";}
//                    if ($p == 'edit') {$perm = "<div class='col-12'><label class='form-check-label'><i class='fa fa-check text-warning'></i> Editar</label></div>";}
//                    if ($p == 'destroy') {$perm = "<div class='col-12'><label class='form-check-label'><i class='fa fa-check text-danger'></i> Deletar</label></div>";}
//
//                    $permissoesSubmodulo .= $perm;
//                }
//
//                $permissoesSubmodulo .= "</div>";
//
//                if ($ctrl > 0) {$permissoes .= $permissoesSubmodulo;}
//            }
//
//            $permissoes .= "</div>";
//
//            //Montando registros de retorno
//            $registros[] = [
//                'id' => $grupo_id,
//                'name' => $grupo_name,
//                'permissoes' => $permissoes
//            ];
//        }
//
//        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $registros);
//    }

    public function filter($array_dados, $empresa_id)
    {
        //Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        //Limpar Querys executadas
        //DB::enableQueryLog();


        //Grupos
        $grupos = $this->grupo
            ->select(['grupos.*'])
            ->where('empresa_id', '=', $empresa_id)
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

        foreach ($grupos as $key => $grupo) {
            $grupo_id = $grupo->id;
            $grupo_name = $grupo->name;

            $permissoes = "<div class='row'>";

            //Varrendo Submodulos para pegar Permissoes por submodulos
            $submodulos = Submodulo::all();
            foreach ($submodulos as $key => $submodulo) {
                $submodulo_id = $submodulo->id;
                $submodulo_name = $submodulo->name;

                //Buscando Permissoes
                $dados = DB::table('grupos_permissoes')
                    ->leftJoin('permissoes', 'permissoes.id', '=', 'grupos_permissoes.permissao_id')
                    ->select(['permissoes.name as permissaoName'])
                    ->where('grupos_permissoes.grupo_id', $grupo_id)
                    ->where('permissoes.submodulo_id', $submodulo_id)
                    ->get();

                $permissoesSubmodulo = "<div class='col-12 col-md-3 pb-3'>";
                $permissoesSubmodulo .= "<b class='pb-3'>".$submodulo_name."</b>";

                $ctrl = 0;
                foreach ($dados as $key => $dado) {
                    $ctrl++;

                    $p = explode('_', $dado->permissaoName);
                    $p = $p[count($p)-1];

                    if ($p == 'list') {$perm = "<div class='col-12'><label class='form-check-label'><i class='fa fa-check text-primary'></i> Listar</label></div>";}
                    if ($p == 'show') {$perm = "<div class='col-12'><label class='form-check-label'><i class='fa fa-check text-info'></i> Mostrar</label></div>";}
                    if ($p == 'create') {$perm = "<div class='col-12'><label class='form-check-label'><i class='fa fa-check text-success'></i> Criar</label></div>";}
                    if ($p == 'edit') {$perm = "<div class='col-12'><label class='form-check-label'><i class='fa fa-check text-warning'></i> Editar</label></div>";}
                    if ($p == 'destroy') {$perm = "<div class='col-12'><label class='form-check-label'><i class='fa fa-check text-danger'></i> Deletar</label></div>";}

                    $permissoesSubmodulo .= $perm;
                }

                $permissoesSubmodulo .= "</div>";

                if ($ctrl > 0) {$permissoes .= $permissoesSubmodulo;}
            }

            $permissoes .= "</div>";

            //Montando registros de retorno
            $registros[] = [
                'id' => $grupo_id,
                'name' => $grupo_name,
                'permissoes' => $permissoes
            ];
        }

        //Código SQL Bruto
        //$sql = DB::getQueryLog();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }
}
