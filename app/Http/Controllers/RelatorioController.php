<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use App\Models\Ferramenta;
use App\Models\Notificacao;
use App\Models\Operacao;
use App\Models\Relatorio;
use App\Models\Situacao;
use App\Models\Submodulo;
use App\Models\Transacao;
use App\Models\User;
use App\Models\Agrupamento;
use App\Models\Grupo;
use App\Models\GrupoRelatorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    public function index($empresa_id)
    {
        //Retorno
        $content = array();

        $content['grupos'] = Grupo::where('empresa_id', $empresa_id)->orderby('name')->get();
        $content['situacoes'] = Situacao::orderby('name')->get();
        $content['users'] = User::join('users_configuracoes', 'users_configuracoes.user_id', 'users.id')->where('empresa_id', $empresa_id)->orderby('name')->get();
        $content['submodulos'] = Submodulo::orderby('name')->get();
        $content['operacoes'] = Operacao::orderby('name')->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $content);
    }

    public function relatorios($empresa_id)
    {
        //Atualisar objeto Auth::user()
        SuporteFacade::setUserLogged($empresa_id);

        //Retorno
        $content = array();

        //Agrupamentos do Usuário
        $content['agrupamentos'] = Relatorio
            ::join('grupos_relatorios', 'grupos_relatorios.relatorio_id', '=', 'relatorios.id')
            ->join('agrupamentos', 'agrupamentos.id', '=', 'relatorios.agrupamento_id')
            ->select('agrupamentos.*')
            ->distinct('agrupamentos.name')
            ->where('grupos_relatorios.grupo_id', Auth::user()->grupo_id)
            ->orderby('agrupamentos.ordem_visualizacao', 'ASC')
            ->get();

        $content['grupo_relatorios'] = GrupoRelatorio
            ::join('relatorios', 'relatorios.id', 'grupos_relatorios.relatorio_id')
            ->select('relatorios.id as relatorio_id', 'relatorios.agrupamento_id', 'relatorios.name as relatorio_name', 'relatorios.descricao as relatorio_descricao', 'relatorios.ordem_visualizacao as relatorio_ordem_visualizacao')
            ->where('grupos_relatorios.grupo_id', Auth::user()->id)
            ->orderby('relatorios.agrupamento_id', 'ASC')
            ->orderby('relatorios.ordem_visualizacao', 'ASC')
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $content);
    }

    public function relatorio1($empresa_id, $grupo_id, $idioma)
    {
        //Relatório Data
        $relatorio_data = date('d/m/Y');

        //Relatório Hora
        $relatorio_hora = date('H:i:s');

        //Relatório Nome
        $relatorio = Relatorio::where('id', 1)->get();
        $relatorio_nome = $relatorio[0]['name'];

        //Parâmetros
        $relatorio_parametros = '';
        if ($grupo_id == 0) {
            $relatorio_parametros .= 'Todos os Grupos';
        } else {
            $grupo = Grupo::where('empresa_id', $empresa_id)->where('id', $grupo_id)->get();
            $relatorio_parametros .= $grupo[0]['name'];
        }
        if ($idioma == 2) {$relatorio_parametros .= ' / '.'Inglês';}

        //Registros
        $relatorio_registros = Grupo
            ::select('grupos.*')
            ->where('empresa_id', $empresa_id)
            ->where(function($query) use($grupo_id) {
                if ($grupo_id != 0) {$query->where('grupos.id', $grupo_id);}
            })
            ->orderby('grupos.name')
            ->get();

        //Retorno
        $content = array();
        $content['relatorio_data'] = $relatorio_data;
        $content['relatorio_hora'] = $relatorio_hora;
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['relatorio_registros'] = $relatorio_registros;

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $content);
    }

    public function relatorio2($empresa_id, $grupo_id, $situacao_id, $idioma)
    {
        //Relatório Data
        $relatorio_data = date('d/m/Y');

        //Relatório Hora
        $relatorio_hora = date('H:i:s');

        //Relatório Nome
        $relatorio = Relatorio::where('id', 2)->get();
        $relatorio_nome = $relatorio[0]['name'];

        //Parâmetros
        $relatorio_parametros = '';
        if ($grupo_id == 0) {
            $relatorio_parametros .= 'Todos os Grupos';
        } else {
            $grupo = Grupo::where('empresa_id', $empresa_id)->where('id', $grupo_id)->get();
            $relatorio_parametros .= $grupo[0]['name'];
        }
        if ($situacao_id == 0) {
            $relatorio_parametros .= ' / '.'Todos as Situações';
        } else {
            $situacao = Situacao::where('id', $situacao_id)->get();
            $relatorio_parametros .= ' / '.$situacao[0]['name'];
        }
        if ($idioma == 2) {$relatorio_parametros .= ' / '.'Inglês';}

        //Registros
        $relatorio_registros = User
            ::join('users_configuracoes', 'users_configuracoes.user_id', 'users.id')
            ->join('grupos', 'grupos.id', 'users_configuracoes.grupo_id')
            ->join('situacoes', 'situacoes.id', 'users_configuracoes.situacao_id')
            ->select('users.*', 'users_configuracoes.*', 'grupos.name as grupo', 'situacoes.name as situacao')
            ->where('users_configuracoes.empresa_id', $empresa_id)
            ->where(function($query) use($grupo_id, $situacao_id) {
                if ($grupo_id != 0) {$query->where('grupos.id', $grupo_id);}
                if ($situacao_id != 0) {$query->where('situacoes.id', $situacao_id);}
            })
            ->orderby('users.name')
            ->get();

        //Retorno
        $content = array();
        $content['relatorio_data'] = $relatorio_data;
        $content['relatorio_hora'] = $relatorio_hora;
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['relatorio_registros'] = $relatorio_registros;

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $content);
    }

    public function relatorio3($empresa_id, $data, $user_id, $submodulo_id, $operacao_id, $dado, $idioma)
    {
        //Relatório Data
        $relatorio_data = date('d/m/Y');

        //Relatório Hora
        $relatorio_hora = date('H:i:s');

        //Relatório Nome
        $relatorio = Relatorio::where('id', 3)->get();
        $relatorio_nome = $relatorio[0]['name'];

        //Parâmetros
        $relatorio_parametros = '';
        if ($data != 'xxxyyyzzz') {
            $relatorio_parametros .= SuporteFacade::getDataFormatada(1, $data);
        }
        if ($user_id == 0) {
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= 'Todos os Usuários';
        } else {
            $user = User::where('id', $user_id)->get();
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= $user[0]['name'];
        }
        if ($submodulo_id == 0) {
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= 'Todos os Submódulos';
        } else {
            $submodulo = Submodulo::where('id', $submodulo_id)->get();
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= $submodulo[0]['name'];
        }
        if ($operacao_id == 0) {
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= 'Todas as Operações';
        } else {
            $operacao = Operacao::where('id', $operacao_id)->get();
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= $operacao[0]['name'];
        }
        if ($dado != 'xxxyyyzzz') {
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= $dado;
        }
        if ($idioma == 2) {$relatorio_parametros .= ' / '.'Inglês';}

        //Registros
        $relatorio_registros = Transacao
            ::join('users', 'users.id', 'transacoes.user_id')
            ->join('submodulos', 'submodulos.id', 'transacoes.submodulo_id')
            ->join('operacoes', 'operacoes.id', 'transacoes.operacao_id')
            ->select('transacoes.*', 'users.name as user', 'submodulos.name as submodulo', 'operacoes.name as operacao')
            ->where(function($query) use($data, $user_id, $submodulo_id, $operacao_id, $dado) {
                if ($data != 'xxxyyyzzz') {$query->where('transacoes.date', $data);}
                if ($user_id != 0) {$query->where('transacoes.user_id', $user_id);}
                if ($submodulo_id != 0) {$query->where('transacoes.submodulo_id', $submodulo_id);}
                if ($operacao_id != 0) {$query->where('transacoes.operacao_id', $operacao_id);}
                if ($dado != 'xxxyyyzzz') {$query->where('transacoes.dados', 'LIKE', '%'.$dado.'%');}
            })
            ->orderby('transacoes.date')
            ->orderby('submodulos.name')
            ->orderby('users.name')
            ->get();

        //Retorno
        $content = array();
        $content['relatorio_data'] = $relatorio_data;
        $content['relatorio_hora'] = $relatorio_hora;
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['relatorio_registros'] = $relatorio_registros;

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $content);
    }

    public function relatorio4($empresa_id, $data, $title, $notificacao, $user_id, $idioma)
    {
        //Relatório Data
        $relatorio_data = date('d/m/Y');

        //Relatório Hora
        $relatorio_hora = date('H:i:s');

        //Relatório Nome
        $relatorio = Relatorio::where('id', 4)->get();
        $relatorio_nome = $relatorio[0]['name'];

        //Parâmetros
        $relatorio_parametros = '';

        if ($data != 'xxxyyyzzz') {
            $relatorio_parametros .= SuporteFacade::getDataFormatada(1, $data);
        }
        if ($title != 'xxxyyyzzz') {
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= $title;
        }
        if ($notificacao != 'xxxyyyzzz') {
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= $notificacao;
        }
        if ($user_id == 0) {
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= 'Todos os Usuários';
        } else {
            $user = User::where('id', $user_id)->get();
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= $user[0]['name'];
        }
        if ($idioma == 2) {$relatorio_parametros .= ' / '.'Inglês';}

        //Registros
        $relatorio_registros = Notificacao
            ::join('users', 'users.id', 'notificacoes.user_id')
            ->select('notificacoes.*', 'users.name as user')
            ->where(function($query) use($data, $title, $notificacao, $user_id) {
                if ($data != 'xxxyyyzzz') {$query->where('notificacoes.date', $data);}
                if ($title != 'xxxyyyzzz') {$query->where('notificacoes.title', 'LIKE', '%'.$title.'%');}
                if ($notificacao != 'xxxyyyzzz') {$query->where('notificacoes.notificacao', 'LIKE', '%'.$notificacao.'%');}
                if ($user_id != 0) {$query->where('notificacoes.user_id', $user_id);}
            })
            ->orderby('notificacoes.date')
            ->orderby('notificacoes.time')
            ->orderby('notificacoes.user_id')
            ->get();

        //Retorno
        $content = array();
        $content['relatorio_data'] = $relatorio_data;
        $content['relatorio_hora'] = $relatorio_hora;
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['relatorio_registros'] = $relatorio_registros;

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $content);
    }

    public function relatorio5($empresa_id, $name, $descricao, $url, $user_id, $idioma)
    {
        //Relatório Data
        $relatorio_data = date('d/m/Y');

        //Relatório Hora
        $relatorio_hora = date('H:i:s');

        //Relatório Nome
        $relatorio = Relatorio::where('id', 5)->get();
        $relatorio_nome = $relatorio[0]['name'];

        //Parâmetros
        $relatorio_parametros = '';

        if ($name != 'xxxyyyzzz') {
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= $name;
        }
        if ($descricao != 'xxxyyyzzz') {
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= $descricao;
        }
        if ($url != 'xxxyyyzzz') {
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= $url;
        }
        if ($user_id == 0) {
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= 'Todos os Usuários';
        } else {
            $user = User::where('id', $user_id)->get();
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= $user[0]['name'];
        }
        if ($idioma == 2) {$relatorio_parametros .= ' / '.'Inglês';}

        //Registros
        $relatorio_registros = Ferramenta
            ::join('users', 'users.id', 'ferramentas.user_id')
            ->select('ferramentas.*', 'users.name as user')
            ->where(function($query) use($name, $descricao, $url, $user_id) {
                if ($name != 'xxxyyyzzz') {$query->where('ferramentas.name', 'LIKE', '%'.$name.'%');}
                if ($descricao != 'xxxyyyzzz') {$query->where('ferramentas.descricao', 'LIKE', '%'.$descricao.'%');}
                if ($url != 'xxxyyyzzz') {$query->where('ferramentas.url', 'LIKE', '%'.$url.'%');}
                if ($user_id != 0) {$query->where('ferramentas.user_id', $user_id);}
            })
            ->orderby('ferramentas.name')
            ->orderby('ferramentas.url')
            ->orderby('ferramentas.user_id')
            ->get();

        //Retorno
        $content = array();
        $content['relatorio_data'] = $relatorio_data;
        $content['relatorio_hora'] = $relatorio_hora;
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['relatorio_registros'] = $relatorio_registros;

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $content);
    }

    public function relatorio6($empresa_id, $data_inicio, $data_fim, $cidade_id, $cidade, $idioma)
    {
        //Relatório Data
        $relatorio_data = date('d/m/Y');

        //Relatório Hora
        $relatorio_hora = date('H:i:s');

        //Relatório Nome
        $relatorio = Relatorio::where('id', 6)->get();
        $relatorio_nome = $relatorio[0]['name'];

        //Parâmetros
        $relatorio_parametros = SuporteFacade::getDataFormatada(1, $data_inicio).' até ';
        $relatorio_parametros .= SuporteFacade::getDataFormatada(1, $data_fim).' / ';
        $relatorio_parametros .= $cidade;
        if ($idioma == 2) {$relatorio_parametros .= ' / '.'Inglês';}

        //Registros
        $relatorio_registros = ['data_inicio' => $data_inicio, 'data_fim' => $data_fim, 'cidade_id' => $cidade_id, 'cidade' => $cidade];

        //Retorno
        $content = array();
        $content['relatorio_data'] = $relatorio_data;
        $content['relatorio_hora'] = $relatorio_hora;
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['relatorio_registros'] = $relatorio_registros;

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $content);
    }
}
