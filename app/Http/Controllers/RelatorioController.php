<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use App\Models\Cliente;
use App\Models\ClienteExecutivo;
use App\Models\Empresa;
use App\Models\EstoqueLocal;
use App\Models\Funcionario;
use App\Models\Operacao;
use App\Models\Relatorio;
use App\Models\Situacao;
use App\Models\Submodulo;
use App\Models\Transacao;
use App\Models\User;
use App\Models\Grupo;
use App\Models\GrupoRelatorio;
use App\Models\Produto;
use App\Models\ProdutoCategoria;
use App\Models\ProdutoEntrada;
use App\Models\ProdutoSituacao;
use App\Models\PontoInteresse;
use App\Models\PontoInteresseEspecialidade;
use App\Models\PontoNatureza;
use App\Models\PontoTipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    public function index()
    {
        //Retorno
        $content = array();

        $content['grupos'] = Grupo::orderby('name')->get();
        $content['situacoes'] = Situacao::orderby('name')->get();
        $content['users'] = User::orderby('name')->get();
        $content['submodulos'] = Submodulo::orderby('name')->get();
        $content['operacoes'] = Operacao::orderby('name')->get();
        $content['clientes_executivos'] = ClienteExecutivo::join('clientes', 'clientes.id', 'clientes_executivos.cliente_id')->select('clientes_executivos.*')->orderby('clientes_executivos.executivo_nome')->get();
        $content['funcionarios'] = Funcionario::orderby('name')->get();
        $content['pontos_tipos'] = PontoTipo::orderby('name')->get();
        $content['pontos_naturezas'] = PontoNatureza::orderby('name')->get();
        $content['produtos_categorias'] = ProdutoCategoria::orderby('name')->get();
        $content['produtos'] = Produto::orderby('name')->get();
        $content['estoques_locais'] = EstoqueLocal::orderby('name')->get();
        $content['empresas'] = Empresa::orderby('name')->get();
        $content['clientes'] = Cliente::orderby('name')->get();
        $content['produtos_situacoes'] = ProdutoSituacao::orderby('name')->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $content);
    }

    public function relatorios()
    {
        //Retorno
        $content = array();

        $grupo_id = Auth::user()->grupo_id;

        $content['grupo_relatorios'] = GrupoRelatorio
            ::join('relatorios', 'relatorios.id', 'grupos_relatorios.relatorio_id')
            ->select('relatorios.id as relatorio_id', 'relatorios.name as relatorio_name', 'relatorios.descricao as relatorio_descricao', 'relatorios.ordem_visualizacao as relatorio_ordem_visualizacao')
            ->where('relatorios.sistema', 1)
            ->where('grupos_relatorios.grupo_id', $grupo_id)
            ->orderby('relatorios.ordem_visualizacao', 'ASC')
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $content);
    }

    public function relatorio1($grupo_id, $idioma)
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
            $grupo = Grupo::where('id', $grupo_id)->get();
            $relatorio_parametros .= $grupo[0]['name'];
        }
        if ($idioma == 2) {$relatorio_parametros .= ' / '.'Inglês';}

        //Registros
        $relatorio_registros = Grupo
            ::select('grupos.*')
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

    public function relatorio2($grupo_id, $situacao_id, $idioma)
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
            $grupo = Grupo::where('id', $grupo_id)->get();
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
            ::join('grupos', 'grupos.id', 'users.grupo_id')
            ->join('situacoes', 'situacoes.id', 'users.situacao_id')
            ->select('users.*', 'grupos.name as grupo', 'situacoes.name as situacao')
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

    public function relatorio3($data, $user_id, $submodulo_id, $operacao_id, $dado, $idioma)
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

    public function relatorio6($data_inicio, $data_fim, $cidade_id, $cidade, $idioma)
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

    public function relatorio8($ponto_tipo_id, $ponto_natureza_id, $modelo, $idioma)
    {
        // Relatório Data
        $relatorio_data = date('d/m/Y');

        // Relatório Hora
        $relatorio_hora = date('H:i:s');

        // Relatório Nome
        $relatorio = Relatorio::where('id', 8)->get();
        $relatorio_nome = $relatorio[0]['name'];

        // Parâmetros
        $relatorio_parametros = '';
        if ($ponto_tipo_id == 0) {
            $relatorio_parametros .= 'Todos os Tipos';
        } else {
            $ponto_tipo = PontoTipo::where('id', $ponto_tipo_id)->get();
            $relatorio_parametros .= $ponto_tipo[0]['name'];
        }
        if ($ponto_natureza_id == 0) {
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= 'Todos as Naturezas';
        } else {
            $ponto_natureza = PontoNatureza::where('id', $ponto_natureza_id)->get();
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= $ponto_natureza[0]['name'];
        }
        if ($idioma == 2) {$relatorio_parametros .= ' / '.'Inglês';}

        // Registros
        $relatorio_registros = PontoInteresse
            ::join('pontos_tipos', 'pontos_tipos.id', 'pontos_interesse.ponto_tipo_id')
            ->leftjoin('pontos_naturezas', 'pontos_naturezas.id', 'pontos_interesse.ponto_natureza_id')
            ->select('pontos_interesse.*', 'pontos_tipos.name as ponto_tipo', 'pontos_naturezas.name as ponto_natureza')
            ->where(function($query) use($ponto_tipo_id, $ponto_natureza_id) {
                if ($ponto_tipo_id != 0) {$query->where('pontos_tipos.id', $ponto_tipo_id);}
                if ($ponto_natureza_id != 0) {$query->where('pontos_naturezas.id', $ponto_natureza_id);}
            })
            ->orderby('pontos_interesse.name')
            ->get();

        // Obtém todos os IDs dos pontos de interesse encontrados
        $ponto_ids = $relatorio_registros->pluck('id');

        $relatorio_registros_especialidades = PontoInteresseEspecialidade
            ::join('especialidades', 'especialidades.id', 'pontos_interesse_especialidades.especialidade_id')
            ->join('especialidades_tipos', 'especialidades_tipos.id', 'especialidades.especialidade_tipo_id')
            ->select('pontos_interesse_especialidades.ponto_interesse_id', 'especialidades_tipos.name as especialidadeTipoName', 'especialidades.name as especialidadeName')
            ->whereIn('pontos_interesse_especialidades.ponto_interesse_id', $ponto_ids)
            ->get();

        // Retorno
        $content = array();
        $content['relatorio_data'] = $relatorio_data;
        $content['relatorio_hora'] = $relatorio_hora;
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_modelo'] = $modelo;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['relatorio_registros'] = $relatorio_registros;
        $content['relatorio_registros_especialidades'] = $relatorio_registros_especialidades;

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $content);
    }

    public function relatorio9($idioma)
    {
        // Relatório Data
        $relatorio_data = date('d/m/Y');

        // Relatório Hora
        $relatorio_hora = date('H:i:s');

        // Relatório Nome
        $relatorio = Relatorio::where('id', 9)->get();
        $relatorio_nome = $relatorio[0]['name'];

        // Parâmetros
        $relatorio_parametros = '';
        if ($idioma == 2) {$relatorio_parametros .= ' / '.'Inglês';}

        // Registros
        $relatorio_registros = [];

        // Retorno
        $content = array();
        $content['relatorio_data'] = $relatorio_data;
        $content['relatorio_hora'] = $relatorio_hora;
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['relatorio_registros'] = $relatorio_registros;

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $content);
    }

    public function relatorio10($produto_id, $produto_categoria_id, $estoque_local_id, $empresa_id, $cliente_id, $produto_situacao_id, $idioma)
    {
        //Relatório Data
        $relatorio_data = date('d/m/Y');

        // Relatório Hora
        $relatorio_hora = date('H:i:s');

        // Relatório Nome
        $relatorio = Relatorio::where('id', 10)->get();
        $relatorio_nome = $relatorio[0]['name'];

        // Parâmetros
        $relatorio_parametros = '';

        if ($produto_id == 0) {
            //$relatorio_parametros .= 'Todos os Materiais';
        } else {
            $produto = Produto::where('id', $produto_id)->get();
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= $produto[0]['name'];
        }
        if ($produto_categoria_id == 0) {
            //$relatorio_parametros .= 'Todas as Categorias';
        } else {
            $produto_categoria = ProdutoCategoria::where('id', $produto_categoria_id)->get();
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= $produto_categoria[0]['name'];
        }
        if ($estoque_local_id == 0) {
            //$relatorio_parametros .= 'Todos os Locais';
        } else {
            $estoque_local = EstoqueLocal::where('id', $estoque_local_id)->get();
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= $estoque_local[0]['name'];
        }
        if ($empresa_id == 0) {
            //$relatorio_parametros .= 'Todas as Empresas';
        } else {
            $empresa = Empresa::where('id', $empresa_id)->get();
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= $empresa[0]['name'];
        }
        if ($cliente_id == 0) {
            //$relatorio_parametros .= 'Todos os Clientes';
        } else {
            $cliente = Cliente::where('id', $cliente_id)->get();
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= $cliente[0]['name'];
        }
        if ($produto_situacao_id == 0) {
            //$relatorio_parametros .= 'Todas as Situações';
        } else {
            $produto_situacao = ProdutoSituacao::where('id', $produto_situacao_id)->get();
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= $produto_situacao[0]['name'];
        }
        if ($idioma == 2) {$relatorio_parametros .= ' / '.'Inglês';}

        // Registros
        $relatorio_registros = ProdutoEntrada
            ::join('produtos_entradas_itens', 'produtos_entradas_itens.produto_entrada_id', 'produtos_entradas.id')
            ->join('produtos', 'produtos.id', 'produtos_entradas_itens.produto_id')
            ->join('produto_categorias', 'produto_categorias.id', 'produtos.produto_categoria_id')
            ->join('produto_situacoes', 'produto_situacoes.id', 'produtos_entradas_itens.produto_situacao_id')
            ->join('estoques_locais', 'estoques_locais.id', 'produtos_entradas_itens.estoque_local_id')
            ->join('estoques', 'estoques.id', 'estoques_locais.estoque_id')
            ->leftjoin('empresas', 'empresas.id', 'estoques_locais.empresa_id')
            ->leftjoin('clientes', 'clientes.id', 'estoques_locais.cliente_id')
            ->select(
                'produtos.name as produto_nome',
                'produtos.descricao as produto_descricao',
                'produtos.fotografia as produto_fotografia',
                'produtos.ca as produto_ca',

                'produto_categorias.name as produto_categoria',

                'produtos_entradas.data_emissao as produto_data_aquisicao',

                'produtos_entradas_itens.id',
                'produtos_entradas_itens.produto_id',
                'produtos_entradas_itens.produto_numero_patrimonio as produto_numero_patrimonio',
                'produtos_entradas_itens.produto_valor_unitario as produto_valor_unitario',

                'estoques.name as produto_estoque_nome',

                'estoques_locais.name as produto_local',
                'estoques_locais.estoque_id as produto_estoque_id',

                'produto_situacoes.id as produto_situacao_id',
                'produto_situacoes.name as produto_situacao',

                'empresas.name as produto_local_empresa',
                'clientes.name as produto_local_cliente'
            );

        // Filtro $produto_id
        if ($produto_id != 0) {
            $relatorio_registros->where('produtos_entradas_itens.produto_id', $produto_id);
        }

        // Filtro $produto_categoria_id
        if ($produto_categoria_id != 0) {
            $relatorio_registros->where('produto_categorias.id', $produto_categoria_id);
        }

        // Filtro $estoque_local_id
        if ($estoque_local_id != 0) {
            $relatorio_registros->where('estoques_locais.id', $estoque_local_id);
        }

        // Filtro $empresa_id
        if ($empresa_id != 0) {
            $relatorio_registros->where('empresas.id', $empresa_id);
        }

        // Filtro $cliente_id
        if ($cliente_id != 0) {
            $relatorio_registros->where('clientes.id', $cliente_id);
        }

        // Filtro $produto_situacao_id
        if ($produto_situacao_id != 0) {
            $relatorio_registros->where('produto_situacoes.id', $produto_situacao_id);
        }

        $relatorio_registros = $relatorio_registros->orderBy('produtos_entradas_itens.produto_numero_patrimonio')->get();

        // Retorno
        $content = array();
        $content['relatorio_data'] = $relatorio_data;
        $content['relatorio_hora'] = $relatorio_hora;
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['relatorio_registros'] = $relatorio_registros;

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $content);
    }
}
