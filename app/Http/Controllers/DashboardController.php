<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use App\Models\Cliente;
use App\Models\Funcionario;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index($data)
    {
        $content = array();

        //Users
        if (substr($data, 0, 1) == 1) {
            //Quantidade de Registros
            $content['dashboardsUsersQtd'] = User::count();

            //Distribuição por Grupos
            //$content['dashboardsUsersGrupos'] = DB::select("SELECT grupos.name, count(users.id) as qtd FROM users INNER JOIN grupos ON users.grupo_id=grupos.id GROUP BY grupos.name ORDER BY grupos.name");
            $content['dashboardsUsersGrupos'] = DB::select("
                        SELECT grupos.name, count(users.id) as qtd FROM users
                        INNER JOIN grupos ON users.grupo_id=grupos.id 
                        GROUP BY grupos.name ORDER BY grupos.name
            ");

            //Distribuição por Situacoes
            $content['dashboardsUsersSituacoes'] = DB::select("
                        SELECT situacoes.name, count(users.id) as qtd FROM users 
                        INNER JOIN situacoes ON users.situacao_id=situacoes.id
                        GROUP BY situacoes.name ORDER BY situacoes.name
            ");
        }

        //Funcionarios
        if (substr($data, 2, 1) == 1) {
            $content['dashboardsFuncionariosQtd'] = Funcionario::count();

            //Distribuição por Funções
            $content['dashboardsFuncionariosFuncoes'] = DB::select("SELECT funcoes.name, count(funcionarios.id) as qtd FROM funcionarios INNER JOIN funcoes ON funcionarios.funcao_id=funcoes.id GROUP BY funcoes.name ORDER BY funcoes.name");

            //Distribuição por Contratações
            $content['dashboardsFuncionariosContratacoes'] = DB::select("SELECT contratacao_tipos.name, count(funcionarios.id) as qtd FROM funcionarios INNER JOIN contratacao_tipos ON funcionarios.contratacao_tipo_id=contratacao_tipos.id GROUP BY contratacao_tipos.name ORDER BY contratacao_tipos.name");

            //Distribuição por Gêneros
            $content['dashboardsFuncionariosGeneros'] = DB::select("SELECT generos.name, count(funcionarios.id) as qtd FROM funcionarios INNER JOIN generos ON funcionarios.genero_id=generos.id GROUP BY generos.name ORDER BY generos.name");
        }

        //Clientes
        if (substr($data, 4, 1) == 1) {
            $content['dashboardsClientesQtd'] = Cliente::count();

            //Distribuição por Status
            $content['dashboardsClientesStatus'] = DB::select("SELECT status, count(clientes.id) as qtd FROM clientes GROUP BY status ORDER BY status");

            //Distribuição por Tipos
            $content['dashboardsClientesTipos'] = DB::select("SELECT tipo, count(clientes.id) as qtd FROM clientes GROUP BY tipo ORDER BY tipo");
        }

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $content);
    }
}
