<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubmodulosSeeder extends Seeder
{
    public function run()
    {
        DB::table('submodulos')->insert([
            //Home
            ['id' => '1', 'modulo_id' => '1', 'name' => 'Grupos', 'menu_text' => 'Grupos', 'menu_url' => 'grupos', 'menu_route' => 'grupos', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'grupos', 'prefix_route' => 'grupos', 'mobile' => 0, 'menu_text_mobile' => '', 'viewing_order' => 15],
            ['id' => '2', 'modulo_id' => '1', 'name' => 'Usuários', 'menu_text' => 'Usuários', 'menu_url' => 'users', 'menu_route' => 'users', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'users', 'prefix_route' => 'users', 'mobile' => 0, 'menu_text_mobile' => '', 'viewing_order' => 20],
            ['id' => '4', 'modulo_id' => '1', 'name' => 'Log de Transações', 'menu_text' => 'Log de Transações', 'menu_url' => 'transacoes', 'menu_route' => 'transacoes', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'transacoes', 'prefix_route' => 'transacoes', 'mobile' => 0, 'menu_text_mobile' => '', 'viewing_order' => 30],
            ['id' => '14', 'modulo_id' => '1', 'name' => 'Funcionários', 'menu_text' => 'Funcionários', 'menu_url' => 'funcionarios', 'menu_route' => 'funcionarios', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'funcionarios', 'prefix_route' => 'funcionarios', 'mobile' => 0, 'menu_text_mobile' => '', 'viewing_order' => 40],
            ['id' => '16', 'modulo_id' => '1', 'name' => 'Clientes', 'menu_text' => 'Clientes', 'menu_url' => 'clientes', 'menu_route' => 'clientes', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'clientes', 'prefix_route' => 'clientes', 'mobile' => 1, 'menu_text_mobile' => 'Meus Clientes', 'viewing_order' => 50],
            ['id' => '17', 'modulo_id' => '1', 'name' => 'Dashboards', 'menu_text' => 'Dashboards', 'menu_url' => 'dashboards', 'menu_route' => 'dashboards', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'dashboards', 'prefix_route' => 'dashboards', 'mobile' => 1, 'menu_text_mobile' => 'Dashboard', 'viewing_order' => 10],
            ['id' => '18', 'modulo_id' => '1', 'name' => 'Fornecedores', 'menu_text' => 'Fornecedores', 'menu_url' => 'fornecedores', 'menu_route' => 'fornecedores', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'fornecedores', 'prefix_route' => 'fornecedores', 'mobile' => 0, 'menu_text_mobile' => '', 'viewing_order' => 60],
            ['id' => '19', 'modulo_id' => '1', 'name' => 'Usuários Perfil', 'menu_text' => 'Usuários Perfil', 'menu_url' => 'users_perfil', 'menu_route' => 'users_perfil', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'users_perfil', 'prefix_route' => 'users_perfil', 'mobile' => 0, 'menu_text_mobile' => '', 'viewing_order' => 0],
            ['id' => '20', 'modulo_id' => '1', 'name' => 'Serviços', 'menu_text' => 'Serviços', 'menu_url' => 'servicos', 'menu_route' => 'servicos', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'servicos', 'prefix_route' => 'servicos', 'mobile' => 1, 'menu_text_mobile' => 'Meus Serviços', 'viewing_order' => 45],
            ['id' => '21', 'modulo_id' => '1', 'name' => 'Propostas', 'menu_text' => 'Propostas', 'menu_url' => 'propostas', 'menu_route' => 'propostas', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'propostas', 'prefix_route' => 'propostas', 'mobile' => 1, 'menu_text_mobile' => 'Minhas Propostas', 'viewing_order' => 90],
            ['id' => '22', 'modulo_id' => '1', 'name' => 'Visitas Técnicas', 'menu_text' => 'Visitas Técnicas', 'menu_url' => 'visitas_tecnicas', 'menu_route' => 'visitas_tecnicas', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'visitas_tecnicas', 'prefix_route' => 'visitas_tecnicas', 'mobile' => 1, 'menu_text_mobile' => 'Minhas Visitas Técnicas', 'viewing_order' => 110],
            ['id' => '23', 'modulo_id' => '1', 'name' => 'Brigadas Incêndios', 'menu_text' => 'Brigadas Incêndios', 'menu_url' => 'brigadas', 'menu_route' => 'brigadas', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'brigadas', 'prefix_route' => 'brigadas', 'mobile' => 1, 'menu_text_mobile' => 'Minhas Brigadas Incêndios', 'viewing_order' => 120],
            ['id' => '25', 'modulo_id' => '1', 'name' => 'Clientes Serviços', 'menu_text' => 'Clientes Serviços', 'menu_url' => 'clientes_servicos', 'menu_route' => 'clientes_servicos', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'clientes_servicos', 'prefix_route' => 'clientes_servicos', 'mobile' => 0, 'menu_text_mobile' => '', 'viewing_order' => 55],

            //Sistema
            ['id' => '3', 'modulo_id' => '2', 'name' => 'Notificações', 'menu_text' => 'Notificações', 'menu_url' => 'notificacoes', 'menu_route' => 'notificacoes', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'notificacoes', 'prefix_route' => 'notificacoes', 'mobile' => 1, 'menu_text_mobile' => 'Minhas Notificações', 'viewing_order' => 25],
            ['id' => '5', 'modulo_id' => '2', 'name' => 'Ferramentas', 'menu_text' => 'Ferramentas', 'menu_url' => 'ferramentas', 'menu_route' => 'ferramentas', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'ferramentas', 'prefix_route' => 'ferramentas', 'mobile' => 0, 'menu_text_mobile' => '', 'viewing_order' => 35],

            //Relatórios

            //Auxiliares
            ['id' => '6', 'modulo_id' => '4', 'name' => 'Bancos', 'menu_text' => 'Bancos', 'menu_url' => 'bancos', 'menu_route' => 'bancos', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'bancos', 'prefix_route' => 'bancos', 'mobile' => 0, 'menu_text_mobile' => '', 'viewing_order' => 75],
            ['id' => '7', 'modulo_id' => '4', 'name' => 'Departamentos', 'menu_text' => 'Departamentos', 'menu_url' => 'departamentos', 'menu_route' => 'departamentos', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'departamentos', 'prefix_route' => 'departamentos', 'mobile' => 0, 'menu_text_mobile' => '', 'viewing_order' => 43],
            ['id' => '8', 'modulo_id' => '4', 'name' => 'Estados Civis', 'menu_text' => 'Estados Civis', 'menu_url' => 'estados_civis', 'menu_route' => 'estados_civis', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'estados_civis', 'prefix_route' => 'estados_civis', 'mobile' => 0, 'menu_text_mobile' => '', 'viewing_order' => 50],
            ['id' => '9', 'modulo_id' => '4', 'name' => 'Nacionalidades', 'menu_text' => 'Nacionalidades', 'menu_url' => 'nacionalidades', 'menu_route' => 'nacionalidades', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'nacionalidades', 'prefix_route' => 'nacionalidades', 'mobile' => 0, 'menu_text_mobile' => '', 'viewing_order' => 55],
            ['id' => '10', 'modulo_id' => '4', 'name' => 'Escolaridades', 'menu_text' => 'Escolaridades', 'menu_url' => 'escolaridades', 'menu_route' => 'escolaridades', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'escolaridades', 'prefix_route' => 'escolaridades', 'mobile' => 0, 'menu_text_mobile' => '', 'viewing_order' => 60],
            ['id' => '11', 'modulo_id' => '4', 'name' => 'Naturalidades', 'menu_text' => 'Naturalidades', 'menu_url' => 'naturalidades', 'menu_route' => 'naturalidades', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'naturalidades', 'prefix_route' => 'naturalidades', 'mobile' => 0, 'menu_text_mobile' => '', 'viewing_order' => 65],
            ['id' => '12', 'modulo_id' => '4', 'name' => 'Gêneros', 'menu_text' => 'Gêneros', 'menu_url' => 'generos', 'menu_route' => 'generos', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'generos', 'prefix_route' => 'generos', 'mobile' => 0, 'menu_text_mobile' => '', 'viewing_order' => 70],
            ['id' => '13', 'modulo_id' => '4', 'name' => 'Funções', 'menu_text' => 'Funções', 'menu_url' => 'funcoes', 'menu_route' => 'funcoes', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'funcoes', 'prefix_route' => 'funcoes', 'mobile' => 0, 'menu_text_mobile' => '', 'viewing_order' => 40],
            ['id' => '15', 'modulo_id' => '4', 'name' => 'Órgãos Identidades', 'menu_text' => 'Órgãos Identidades', 'menu_url' => 'identidade_orgaos', 'menu_route' => 'identidade_orgaos', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'identidade_orgaos', 'prefix_route' => 'identidade_orgaos', 'mobile' => 0, 'menu_text_mobile' => '', 'viewing_order' => 80],
            ['id' => '24', 'modulo_id' => '4', 'name' => 'Empresas', 'menu_text' => 'Empresas', 'menu_url' => 'empresas', 'menu_route' => 'empresas', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'empresas', 'prefix_route' => 'empresas', 'mobile' => 0, 'menu_text_mobile' => '', 'viewing_order' => 5],
        ]);
    }
}
