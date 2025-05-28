<?php

namespace Database\Seeders;

use App\Models\GrupoPermissao;
use App\Models\Mapa;
use App\Models\MapaModelo;
use App\Models\MapaPontoTipo;
use App\Models\RelatorioExaustaoPergunta;
use App\Models\RelatorioExaustaoStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Permissao;

class ZZZ_20250526_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        //Submódulos
        DB::table('submodulos')->insert([
            ['id' => '32', 'modulo_id' => '1', 'name' => 'Relatórios - Exaustão', 'menu_text' => 'Relatórios - Exaustão', 'menu_url' => 'relatorios_exaustoes', 'menu_route' => 'relatorios_exaustoes', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'relatorios_exaustoes', 'prefix_route' => 'relatorios_exaustoes', 'mobile' => 0, 'menu_text_mobile' => 'Meus ', 'viewing_order' => 125]
        ]);

        //Permissões
        Permissao::create(['id' => 152, 'submodulo_id' => 32, 'name' => 'relatorios_exaustoes_list', 'description' => 'Visualizar Registro - Relatórios Exautões']);
        Permissao::create(['id' => 153, 'submodulo_id' => 32, 'name' => 'relatorios_exaustoes_create', 'description' => 'Criar Registro - Relatórios Exautões']);
        Permissao::create(['id' => 154, 'submodulo_id' => 32, 'name' => 'relatorios_exaustoes_show', 'description' => 'Visualizar Registro - Relatórios Exautões']);
        Permissao::create(['id' => 155, 'submodulo_id' => 32, 'name' => 'relatorios_exaustoes_edit', 'description' => 'Editar Registro - Relatórios Exautões']);
        Permissao::create(['id' => 156, 'submodulo_id' => 32, 'name' => 'relatorios_exaustoes_destroy', 'description' => 'Deletar Registro - Relatórios Exautões']);

        //Grupo Permissão
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 152]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 153]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 154]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 155]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 156]);

        //Relatórios Exaustões Status
        RelatorioExaustaoStatus::create(['id' => 1, 'name' => 'ABERTO']);
        RelatorioExaustaoStatus::create(['id' => 2, 'name' => 'EM ANDAMENTO']);
        RelatorioExaustaoStatus::create(['id' => 3, 'name' => 'CONCLUÍDO']);
        RelatorioExaustaoStatus::create(['id' => 4, 'name' => 'FINALIZADO']);
        RelatorioExaustaoStatus::create(['id' => 5, 'name' => 'CANCELADO']);
    }
}
