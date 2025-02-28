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
    public function index($data, $empresa_id)
    {
        $content = array();

        //Users
        if (substr($data, 0, 1) == 1) {
            //Quantidade de Registros
            $content['dashboardsUsersQtd'] = User::join('users_configuracoes', 'users_configuracoes.user_id', 'users.id')->where('users_configuracoes.empresa_id', '=', $empresa_id)->count();

            //Distribuição por Grupos
            //$content['dashboardsUsersGrupos'] = DB::select("SELECT grupos.name, count(users.id) as qtd FROM users INNER JOIN grupos ON users.grupo_id=grupos.id GROUP BY grupos.name ORDER BY grupos.name");
            $content['dashboardsUsersGrupos'] = DB::select("
                        SELECT grupos.name, count(users.id) as qtd FROM users
                        INNER JOIN users_configuracoes ON users.id=users_configuracoes.user_id 
                        INNER JOIN grupos ON users_configuracoes.grupo_id=grupos.id 
                        WHERE users_configuracoes.empresa_id = ".$empresa_id." GROUP BY grupos.name ORDER BY grupos.name
            ");

            //Distribuição por Situacoes
            $content['dashboardsUsersSituacoes'] = DB::select("
                        SELECT situacoes.name, count(users.id) as qtd FROM users 
                        INNER JOIN users_configuracoes ON users.id=users_configuracoes.user_id 
                        INNER JOIN situacoes ON users_configuracoes.situacao_id=situacoes.id 
                        WHERE users_configuracoes.empresa_id = ".$empresa_id." GROUP BY situacoes.name ORDER BY situacoes.name
            ");
        }

        //Funcionarios
        if (substr($data, 2, 1) == 1) {
            $content['dashboardsFuncionariosQtd'] = Funcionario::where('empresa_id', '=', $empresa_id)->count();

            //Distribuição por Funções
            $content['dashboardsFuncionariosFuncoes'] = DB::select("SELECT funcoes.name, count(funcionarios.id) as qtd FROM funcionarios INNER JOIN funcoes ON funcionarios.funcao_id=funcoes.id WHERE funcionarios.empresa_id=".$empresa_id." GROUP BY funcoes.name ORDER BY funcoes.name");

            //Distribuição por Gêneros
            $content['dashboardsFuncionariosGeneros'] = DB::select("SELECT generos.name, count(funcionarios.id) as qtd FROM funcionarios INNER JOIN generos ON funcionarios.genero_id=generos.id WHERE funcionarios.empresa_id=".$empresa_id." GROUP BY generos.name ORDER BY generos.name");
        }

        //Clientes
        if (substr($data, 4, 1) == 1) {
            $content['dashboardsClientesQtd'] = Cliente::where('empresa_id', '=', $empresa_id)->count();

            //Distribuição por Status
            $content['dashboardsClientesStatus'] = DB::select("SELECT status, count(clientes.id) as qtd FROM clientes WHERE clientes.empresa_id=".$empresa_id." GROUP BY status ORDER BY status");

            //Distribuição por Tipos
            $content['dashboardsClientesTipos'] = DB::select("SELECT tipo, count(clientes.id) as qtd FROM clientes WHERE clientes.empresa_id=".$empresa_id." GROUP BY tipo ORDER BY tipo");
        }

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $content);
    }
}
