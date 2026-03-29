<?php

namespace Database\Seeders;

use App\Models\Grafico;
use App\Models\Grupo;
use App\Models\GrupoPermissao;
use App\Models\Permissao;
use App\Models\Submodulo;
use Illuminate\Database\Seeder;

class ZZZ_20260316_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        // Domínio Clientes (APAGAR)''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Grupos Permissões
        GrupoPermissao::where('permissao_id', 197)->delete(); // clientes_dashboards_list
        GrupoPermissao::where('permissao_id', 198)->delete(); // clientes_funcionarios_list
        GrupoPermissao::where('permissao_id', 199)->delete(); // clientes_funcionarios_show
        GrupoPermissao::where('permissao_id', 200)->delete(); // clientes_relatorios_list

        // Permissões
        Permissao::where('id', 197)->delete(); // clientes_dashboards_list
        Permissao::where('id', 198)->delete(); // clientes_funcionarios_list
        Permissao::where('id', 199)->delete(); // clientes_funcionarios_show
        Permissao::where('id', 200)->delete(); // clientes_relatorios_list

        // Submódulos
        Submodulo::where('id', 41)->delete(); // Clientes Dashboards
        Submodulo::where('id', 42)->delete(); // Clientes Funcionários
        Submodulo::where('id', 43)->delete(); // Clientes Relatórios
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Colocar permissão para dashboard no Grupo DOMÍNIO CLIENTES'''''''''''''''''''''''''''''''''''''''''''''''''''
        GrupoPermissao::create(['grupo_id' => 11, 'permissao_id' => 81]);
        GrupoPermissao::create(['grupo_id' => 11, 'permissao_id' => 82]);
        GrupoPermissao::create(['grupo_id' => 11, 'permissao_id' => 83]);
        GrupoPermissao::create(['grupo_id' => 11, 'permissao_id' => 84]);
        GrupoPermissao::create(['grupo_id' => 11, 'permissao_id' => 85]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo Dashboards 2 (APAGAR)''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        // Grupo Permissão
        GrupoPermissao::where('permissao_id', 162)->delete();
        GrupoPermissao::where('permissao_id', 163)->delete();
        GrupoPermissao::where('permissao_id', 164)->delete();
        GrupoPermissao::where('permissao_id', 165)->delete();
        GrupoPermissao::where('permissao_id', 166)->delete();

        // Permissões
        Permissao::where('id', 162)->delete();
        Permissao::where('id', 163)->delete();
        Permissao::where('id', 164)->delete();
        Permissao::where('id', 165)->delete();
        Permissao::where('id', 166)->delete();

        // Submódulo
        Submodulo::where('id', 34)->delete();
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo Dashboards 3 (APAGAR)''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        // Grupo Permissão
        GrupoPermissao::where('permissao_id', 167)->delete();
        GrupoPermissao::where('permissao_id', 168)->delete();
        GrupoPermissao::where('permissao_id', 169)->delete();
        GrupoPermissao::where('permissao_id', 170)->delete();
        GrupoPermissao::where('permissao_id', 171)->delete();

        // Permissões
        Permissao::where('id', 167)->delete();
        Permissao::where('id', 168)->delete();
        Permissao::where('id', 169)->delete();
        Permissao::where('id', 170)->delete();
        Permissao::where('id', 171)->delete();

        // Submódulo
        Submodulo::where('id', 35)->delete();
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo Sistemas Preventivos (APAGAR)''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        // Grupo Permissão
        GrupoPermissao::where('permissao_id', 226)->delete();
        GrupoPermissao::where('permissao_id', 227)->delete();
        GrupoPermissao::where('permissao_id', 228)->delete();
        GrupoPermissao::where('permissao_id', 229)->delete();
        GrupoPermissao::where('permissao_id', 230)->delete();

        // Permissões
        Permissao::where('id', 226)->delete();
        Permissao::where('id', 227)->delete();
        Permissao::where('id', 228)->delete();
        Permissao::where('id', 229)->delete();
        Permissao::where('id', 230)->delete();

        // Submódulo
        Submodulo::where('id', 49)->delete();
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Grupos (ALTERAR)'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Grupo::where('id', 11)->update(['sistema' => 2]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Gráficos - Sistema Domínio Clientes - Create'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Grafico::create(['id' => 15, 'sistema' => 2, 'name' => 'Cliente Edificação Lojas', 'dashboard' => 1, 'tipo' => 1, 'ordem_visualizacao' => 40]);
        Grafico::create(['id' => 16, 'sistema' => 2, 'name' => 'Cliente Documentos Exigidos', 'dashboard' => 1, 'tipo' => 1, 'ordem_visualizacao' => 50]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
