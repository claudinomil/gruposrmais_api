<?php

namespace Database\Seeders;

use App\Models\Grupo;
use App\Models\GrupoPermissao;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Permissao;

class PermissoesSeeder extends Seeder
{
    public function run()
    {
        Permissao::create(['id' => 1, 'submodulo_id' => 1, 'name' => 'grupos_list', 'description' => 'Visualizar Registro - Grupos']);
        Permissao::create(['id' => 2, 'submodulo_id' => 1, 'name' => 'grupos_create', 'description' => 'Criar Registro - Grupos']);
        Permissao::create(['id' => 3, 'submodulo_id' => 1, 'name' => 'grupos_show', 'description' => 'Visualizar Registro - Grupos']);
        Permissao::create(['id' => 4, 'submodulo_id' => 1, 'name' => 'grupos_edit', 'description' => 'Editar Registro - Grupos']);
        Permissao::create(['id' => 5, 'submodulo_id' => 1, 'name' => 'grupos_destroy', 'description' => 'Deletar Registro - Grupos']);

        Permissao::create(['id' => 6, 'submodulo_id' => 2, 'name' => 'users_list', 'description' => 'Visualizar Registro - Usuários']);
        Permissao::create(['id' => 7, 'submodulo_id' => 2, 'name' => 'users_create', 'description' => 'Criar Registro - Usuários']);
        Permissao::create(['id' => 8, 'submodulo_id' => 2, 'name' => 'users_show', 'description' => 'Visualizar Registro - Usuários']);
        Permissao::create(['id' => 9, 'submodulo_id' => 2, 'name' => 'users_edit', 'description' => 'Editar Registro - Usuários']);
        Permissao::create(['id' => 10, 'submodulo_id' => 2, 'name' => 'users_destroy', 'description' => 'Deletar Registro - Usuários']);

        Permissao::create(['id' => 11, 'submodulo_id' => 3, 'name' => 'notificacoes_list', 'description' => 'Visualizar Registro - Notificações']);
        Permissao::create(['id' => 12, 'submodulo_id' => 3, 'name' => 'notificacoes_create', 'description' => 'Criar Registro - Notificações']);
        Permissao::create(['id' => 13, 'submodulo_id' => 3, 'name' => 'notificacoes_show', 'description' => 'Visualizar Registro - Notificações']);
        Permissao::create(['id' => 14, 'submodulo_id' => 3, 'name' => 'notificacoes_edit', 'description' => 'Editar Registro - Notificações']);
        Permissao::create(['id' => 15, 'submodulo_id' => 3, 'name' => 'notificacoes_destroy', 'description' => 'Deletar Registro - Notificações']);

        Permissao::create(['id' => 16, 'submodulo_id' => 4, 'name' => 'transacoes_list', 'description' => 'Visualizar Registro - Transações']);
        Permissao::create(['id' => 17, 'submodulo_id' => 4, 'name' => 'transacoes_create', 'description' => 'Criar Registro - Transações']);
        Permissao::create(['id' => 18, 'submodulo_id' => 4, 'name' => 'transacoes_show', 'description' => 'Visualizar Registro - Transações']);
        Permissao::create(['id' => 19, 'submodulo_id' => 4, 'name' => 'transacoes_edit', 'description' => 'Editar Registro - Transações']);
        Permissao::create(['id' => 20, 'submodulo_id' => 4, 'name' => 'transacoes_destroy', 'description' => 'Deletar Registro - Transações']);

        Permissao::create(['id' => 21, 'submodulo_id' => 5, 'name' => 'ferramentas_list', 'description' => 'Visualizar Registro - Ferramentas']);
        Permissao::create(['id' => 22, 'submodulo_id' => 5, 'name' => 'ferramentas_create', 'description' => 'Criar Registro - Ferramentas']);
        Permissao::create(['id' => 23, 'submodulo_id' => 5, 'name' => 'ferramentas_show', 'description' => 'Visualizar Registro - Ferramentas']);
        Permissao::create(['id' => 24, 'submodulo_id' => 5, 'name' => 'ferramentas_edit', 'description' => 'Editar Registro - Ferramentas']);
        Permissao::create(['id' => 25, 'submodulo_id' => 5, 'name' => 'ferramentas_destroy', 'description' => 'Deletar Registro - Ferramentas']);

        Permissao::create(['id' => 26, 'submodulo_id' => 6, 'name' => 'bancos_list', 'description' => 'Visualizar Registro - Bancos']);
        Permissao::create(['id' => 27, 'submodulo_id' => 6, 'name' => 'bancos_create', 'description' => 'Criar Registro - Bancos']);
        Permissao::create(['id' => 28, 'submodulo_id' => 6, 'name' => 'bancos_show', 'description' => 'Visualizar Registro - Bancos']);
        Permissao::create(['id' => 29, 'submodulo_id' => 6, 'name' => 'bancos_edit', 'description' => 'Editar Registro - Bancos']);
        Permissao::create(['id' => 30, 'submodulo_id' => 6, 'name' => 'bancos_destroy', 'description' => 'Deletar Registro - Bancos']);

        Permissao::create(['id' => 31, 'submodulo_id' => 7, 'name' => 'departamentos_list', 'description' => 'Visualizar Registro - Departamentos']);
        Permissao::create(['id' => 32, 'submodulo_id' => 7, 'name' => 'departamentos_create', 'description' => 'Criar Registro - Departamentos']);
        Permissao::create(['id' => 33, 'submodulo_id' => 7, 'name' => 'departamentos_show', 'description' => 'Visualizar Registro - Departamentos']);
        Permissao::create(['id' => 34, 'submodulo_id' => 7, 'name' => 'departamentos_edit', 'description' => 'Editar Registro - Departamentos']);
        Permissao::create(['id' => 35, 'submodulo_id' => 7, 'name' => 'departamentos_destroy', 'description' => 'Deletar Registro - Departamentos']);

        Permissao::create(['id' => 36, 'submodulo_id' => 8, 'name' => 'estados_civis_list', 'description' => 'Visualizar Registro - Estados Civis']);
        Permissao::create(['id' => 37, 'submodulo_id' => 8, 'name' => 'estados_civis_create', 'description' => 'Criar Registro - Estados Civis']);
        Permissao::create(['id' => 38, 'submodulo_id' => 8, 'name' => 'estados_civis_show', 'description' => 'Visualizar Registro - Estados Civis']);
        Permissao::create(['id' => 39, 'submodulo_id' => 8, 'name' => 'estados_civis_edit', 'description' => 'Editar Registro - Estados Civis']);
        Permissao::create(['id' => 40, 'submodulo_id' => 8, 'name' => 'estados_civis_destroy', 'description' => 'Deletar Registro - Estados Civis']);

        Permissao::create(['id' => 41, 'submodulo_id' => 9, 'name' => 'nacionalidades_list', 'description' => 'Visualizar Registro - Nacionalidades']);
        Permissao::create(['id' => 42, 'submodulo_id' => 9, 'name' => 'nacionalidades_create', 'description' => 'Criar Registro - Nacionalidades']);
        Permissao::create(['id' => 43, 'submodulo_id' => 9, 'name' => 'nacionalidades_show', 'description' => 'Visualizar Registro - Nacionalidades']);
        Permissao::create(['id' => 44, 'submodulo_id' => 9, 'name' => 'nacionalidades_edit', 'description' => 'Editar Registro - Nacionalidades']);
        Permissao::create(['id' => 45, 'submodulo_id' => 9, 'name' => 'nacionalidades_destroy', 'description' => 'Deletar Registro - Nacionalidades']);

        Permissao::create(['id' => 46, 'submodulo_id' => 10, 'name' => 'escolaridades_list', 'description' => 'Visualizar Registro - Escolaridades']);
        Permissao::create(['id' => 47, 'submodulo_id' => 10, 'name' => 'escolaridades_create', 'description' => 'Criar Registro - Escolaridades']);
        Permissao::create(['id' => 48, 'submodulo_id' => 10, 'name' => 'escolaridades_show', 'description' => 'Visualizar Registro - Escolaridades']);
        Permissao::create(['id' => 49, 'submodulo_id' => 10, 'name' => 'escolaridades_edit', 'description' => 'Editar Registro - Escolaridades']);
        Permissao::create(['id' => 50, 'submodulo_id' => 10, 'name' => 'escolaridades_destroy', 'description' => 'Deletar Registro - Escolaridades']);

        Permissao::create(['id' => 51, 'submodulo_id' => 11, 'name' => 'naturalidades_list', 'description' => 'Visualizar Registro - Naturalidades']);
        Permissao::create(['id' => 52, 'submodulo_id' => 11, 'name' => 'naturalidades_create', 'description' => 'Criar Registro - Naturalidades']);
        Permissao::create(['id' => 53, 'submodulo_id' => 11, 'name' => 'naturalidades_show', 'description' => 'Visualizar Registro - Naturalidades']);
        Permissao::create(['id' => 54, 'submodulo_id' => 11, 'name' => 'naturalidades_edit', 'description' => 'Editar Registro - Naturalidades']);
        Permissao::create(['id' => 55, 'submodulo_id' => 11, 'name' => 'naturalidades_destroy', 'description' => 'Deletar Registro - Naturalidades']);

        Permissao::create(['id' => 56, 'submodulo_id' => 12, 'name' => 'generos_list', 'description' => 'Visualizar Registro - Gêneros']);
        Permissao::create(['id' => 57, 'submodulo_id' => 12, 'name' => 'generos_create', 'description' => 'Criar Registro - Gêneros']);
        Permissao::create(['id' => 58, 'submodulo_id' => 12, 'name' => 'generos_show', 'description' => 'Visualizar Registro - Gêneros']);
        Permissao::create(['id' => 59, 'submodulo_id' => 12, 'name' => 'generos_edit', 'description' => 'Editar Registro - Gêneros']);
        Permissao::create(['id' => 60, 'submodulo_id' => 12, 'name' => 'generos_destroy', 'description' => 'Deletar Registro - Gêneros']);

        Permissao::create(['id' => 61, 'submodulo_id' => 13, 'name' => 'funcoes_list', 'description' => 'Visualizar Registro - Funções']);
        Permissao::create(['id' => 62, 'submodulo_id' => 13, 'name' => 'funcoes_create', 'description' => 'Criar Registro - Funções']);
        Permissao::create(['id' => 63, 'submodulo_id' => 13, 'name' => 'funcoes_show', 'description' => 'Visualizar Registro - Funções']);
        Permissao::create(['id' => 64, 'submodulo_id' => 13, 'name' => 'funcoes_edit', 'description' => 'Editar Registro - Funções']);
        Permissao::create(['id' => 65, 'submodulo_id' => 13, 'name' => 'funcoes_destroy', 'description' => 'Deletar Registro - Funções']);

        Permissao::create(['id' => 66, 'submodulo_id' => 14, 'name' => 'funcionarios_list', 'description' => 'Visualizar Registro - Funcionários']);
        Permissao::create(['id' => 67, 'submodulo_id' => 14, 'name' => 'funcionarios_create', 'description' => 'Criar Registro - Funcionários']);
        Permissao::create(['id' => 68, 'submodulo_id' => 14, 'name' => 'funcionarios_show', 'description' => 'Visualizar Registro - Funcionários']);
        Permissao::create(['id' => 69, 'submodulo_id' => 14, 'name' => 'funcionarios_edit', 'description' => 'Editar Registro - Funcionários']);
        Permissao::create(['id' => 70, 'submodulo_id' => 14, 'name' => 'funcionarios_destroy', 'description' => 'Deletar Registro - Funcionários']);

        Permissao::create(['id' => 71, 'submodulo_id' => 15, 'name' => 'identidade_orgaos_list', 'description' => 'Visualizar Registro - Órgãos Identidades']);
        Permissao::create(['id' => 72, 'submodulo_id' => 15, 'name' => 'identidade_orgaos_create', 'description' => 'Criar Registro - Órgãos Identidades']);
        Permissao::create(['id' => 73, 'submodulo_id' => 15, 'name' => 'identidade_orgaos_show', 'description' => 'Visualizar Registro - Órgãos Identidades']);
        Permissao::create(['id' => 74, 'submodulo_id' => 15, 'name' => 'identidade_orgaos_edit', 'description' => 'Editar Registro - Órgãos Identidades']);
        Permissao::create(['id' => 75, 'submodulo_id' => 15, 'name' => 'identidade_orgaos_destroy', 'description' => 'Deletar Registro - Órgãos Identidades']);

        Permissao::create(['id' => 76, 'submodulo_id' => 16, 'name' => 'clientes_list', 'description' => 'Visualizar Registro - Clientes']);
        Permissao::create(['id' => 77, 'submodulo_id' => 16, 'name' => 'clientes_create', 'description' => 'Criar Registro - Clientes']);
        Permissao::create(['id' => 78, 'submodulo_id' => 16, 'name' => 'clientes_show', 'description' => 'Visualizar Registro - Clientes']);
        Permissao::create(['id' => 79, 'submodulo_id' => 16, 'name' => 'clientes_edit', 'description' => 'Editar Registro - Clientes']);
        Permissao::create(['id' => 80, 'submodulo_id' => 16, 'name' => 'clientes_destroy', 'description' => 'Deletar Registro - Clientes']);

        Permissao::create(['id' => 81, 'submodulo_id' => 17, 'name' => 'dashboards_list', 'description' => 'Visualizar Registro - Dashboards']);
        Permissao::create(['id' => 82, 'submodulo_id' => 17, 'name' => 'dashboards_create', 'description' => 'Criar Registro - Dashboards']);
        Permissao::create(['id' => 83, 'submodulo_id' => 17, 'name' => 'dashboards_show', 'description' => 'Visualizar Registro - Dashboards']);
        Permissao::create(['id' => 84, 'submodulo_id' => 17, 'name' => 'dashboards_edit', 'description' => 'Editar Registro - Dashboards']);
        Permissao::create(['id' => 85, 'submodulo_id' => 17, 'name' => 'dashboards_destroy', 'description' => 'Deletar Registro - Dashboards']);

        Permissao::create(['id' => 86, 'submodulo_id' => 18, 'name' => 'fornecedores_list', 'description' => 'Visualizar Registro - Fornecedores']);
        Permissao::create(['id' => 87, 'submodulo_id' => 18, 'name' => 'fornecedores_create', 'description' => 'Criar Registro - Fornecedores']);
        Permissao::create(['id' => 88, 'submodulo_id' => 18, 'name' => 'fornecedores_show', 'description' => 'Visualizar Registro - Fornecedores']);
        Permissao::create(['id' => 89, 'submodulo_id' => 18, 'name' => 'fornecedores_edit', 'description' => 'Editar Registro - Fornecedores']);
        Permissao::create(['id' => 90, 'submodulo_id' => 18, 'name' => 'fornecedores_destroy', 'description' => 'Deletar Registro - Fornecedores']);

        Permissao::create(['id' => 91, 'submodulo_id' => 19, 'name' => 'users_perfil_list', 'description' => 'Visualizar Registro - Usuários Perfil']);
        Permissao::create(['id' => 92, 'submodulo_id' => 19, 'name' => 'users_perfil_create', 'description' => 'Criar Registro - Usuários Perfil']);
        Permissao::create(['id' => 93, 'submodulo_id' => 19, 'name' => 'users_perfil_show', 'description' => 'Visualizar Registro - Usuários Perfil']);
        Permissao::create(['id' => 94, 'submodulo_id' => 19, 'name' => 'users_perfil_edit', 'description' => 'Editar Registro - Usuários Perfil']);
        Permissao::create(['id' => 95, 'submodulo_id' => 19, 'name' => 'users_perfil_destroy', 'description' => 'Deletar Registro - Usuários Perfil']);

        Permissao::create(['id' => 96, 'submodulo_id' => 20, 'name' => 'servicos_list', 'description' => 'Visualizar Registro - Serviços']);
        Permissao::create(['id' => 97, 'submodulo_id' => 20, 'name' => 'servicos_create', 'description' => 'Criar Registro - Serviços']);
        Permissao::create(['id' => 98, 'submodulo_id' => 20, 'name' => 'servicos_show', 'description' => 'Visualizar Registro - Serviços']);
        Permissao::create(['id' => 99, 'submodulo_id' => 20, 'name' => 'servicos_edit', 'description' => 'Editar Registro - Serviços']);
        Permissao::create(['id' => 100, 'submodulo_id' => 20, 'name' => 'servicos_destroy', 'description' => 'Deletar Registro - Serviços']);

        Permissao::create(['id' => 101, 'submodulo_id' => 21, 'name' => 'propostas_list', 'description' => 'Visualizar Registro - Propostas']);
        Permissao::create(['id' => 102, 'submodulo_id' => 21, 'name' => 'propostas_create', 'description' => 'Criar Registro - Propostas']);
        Permissao::create(['id' => 103, 'submodulo_id' => 21, 'name' => 'propostas_show', 'description' => 'Visualizar Registro - Propostas']);
        Permissao::create(['id' => 104, 'submodulo_id' => 21, 'name' => 'propostas_edit', 'description' => 'Editar Registro - Propostas']);
        Permissao::create(['id' => 105, 'submodulo_id' => 21, 'name' => 'propostas_destroy', 'description' => 'Deletar Registro - Propostas']);

        Permissao::create(['id' => 106, 'submodulo_id' => 22, 'name' => 'visitas_tecnicas_list', 'description' => 'Visualizar Registro - Visitas Técnicas']);
        Permissao::create(['id' => 107, 'submodulo_id' => 22, 'name' => 'visitas_tecnicas_create', 'description' => 'Criar Registro - Visitas Técnicas']);
        Permissao::create(['id' => 108, 'submodulo_id' => 22, 'name' => 'visitas_tecnicas_show', 'description' => 'Visualizar Registro - Visitas Técnicas']);
        Permissao::create(['id' => 109, 'submodulo_id' => 22, 'name' => 'visitas_tecnicas_edit', 'description' => 'Editar Registro - Visitas Técnicas']);
        Permissao::create(['id' => 110, 'submodulo_id' => 22, 'name' => 'visitas_tecnicas_destroy', 'description' => 'Deletar Registro - Visitas Técnicas']);

        Permissao::create(['id' => 111, 'submodulo_id' => 23, 'name' => 'brigadas_list', 'description' => 'Visualizar Registro - Brigadas Incêndios']);
        Permissao::create(['id' => 112, 'submodulo_id' => 23, 'name' => 'brigadas_create', 'description' => 'Criar Registro - Brigadas Incêndios']);
        Permissao::create(['id' => 113, 'submodulo_id' => 23, 'name' => 'brigadas_show', 'description' => 'Visualizar Registro - Brigadas Incêndios']);
        Permissao::create(['id' => 114, 'submodulo_id' => 23, 'name' => 'brigadas_edit', 'description' => 'Editar Registro - Brigadas Incêndios']);
        Permissao::create(['id' => 115, 'submodulo_id' => 23, 'name' => 'brigadas_destroy', 'description' => 'Deletar Registro - Brigadas Incêndios']);

        Permissao::create(['id' => 116, 'submodulo_id' => 24, 'name' => 'empresas_list', 'description' => 'Visualizar Registro - Empresas']);
        Permissao::create(['id' => 117, 'submodulo_id' => 24, 'name' => 'empresas_create', 'description' => 'Criar Registro - Empresas']);
        Permissao::create(['id' => 118, 'submodulo_id' => 24, 'name' => 'empresas_show', 'description' => 'Visualizar Registro - Empresas']);
        Permissao::create(['id' => 119, 'submodulo_id' => 24, 'name' => 'empresas_edit', 'description' => 'Editar Registro - Empresas']);
        Permissao::create(['id' => 120, 'submodulo_id' => 24, 'name' => 'empresas_destroy', 'description' => 'Deletar Registro - Empresas']);

        Permissao::create(['id' => 121, 'submodulo_id' => 25, 'name' => 'clientes_servicos_list', 'description' => 'Visualizar Registro - Clientes Serviços']);
        Permissao::create(['id' => 122, 'submodulo_id' => 25, 'name' => 'clientes_servicos_create', 'description' => 'Criar Registro - Clientes Serviços']);
        Permissao::create(['id' => 123, 'submodulo_id' => 25, 'name' => 'clientes_servicos_show', 'description' => 'Visualizar Registro - Clientes Serviços']);
        Permissao::create(['id' => 124, 'submodulo_id' => 25, 'name' => 'clientes_servicos_edit', 'description' => 'Editar Registro - Clientes Serviços']);
        Permissao::create(['id' => 125, 'submodulo_id' => 25, 'name' => 'clientes_servicos_destroy', 'description' => 'Deletar Registro - Clientes Serviços']);
    }
}
