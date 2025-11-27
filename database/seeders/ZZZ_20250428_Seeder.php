<?php

namespace Database\Seeders;

use App\Models\FormaPagamento;
use App\Models\FormaPagamentoStatus;
use App\Models\GrupoPermissao;
use App\Models\GrupoRelatorio;
use App\Models\OrdemServicoPrioridade;
use App\Models\OrdemServicoStatus;
use App\Models\OrdemServicoTipo;
use App\Models\Relatorio;
use App\Models\Servico;
use App\Models\ServicoTipo;
use App\Models\VeiculoCategoria;
use App\Models\VeiculoCombustivel;
use App\Models\VeiculoMarca;
use App\Models\VeiculoModelo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Permissao;

class ZZZ_20250428_Seeder extends Seeder
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
            ['id' => '29', 'modulo_id' => '3', 'name' => 'Relatórios', 'menu_text' => 'Relatórios', 'menu_url' => 'relatorios', 'menu_route' => 'relatorios', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'relatorios', 'prefix_route' => 'relatorios', 'mobile' => 0, 'menu_text_mobile' => 'Meus Relatórios', 'viewing_order' => 10]
        ]);

        //Permissões
        Permissao::create(['id' => 141, 'submodulo_id' => 29, 'name' => 'relatorios_list', 'description' => 'Visualizar Registro - Relatórios']);

        //Grupo Permissão
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 141]);

        // Relatórios
        Relatorio::create(['id' => 1, 'name' => 'Grupos', 'descricao' => '', 'ordem_visualizacao' => 1]);
        Relatorio::create(['id' => 2, 'name' => 'Usuários', 'descricao' => '', 'ordem_visualizacao' => 2]);
        Relatorio::create(['id' => 3, 'name' => 'Log de Transações', 'descricao' => '', 'ordem_visualizacao' => 3]);
        Relatorio::create(['id' => 4, 'name' => 'Notificações', 'descricao' => '', 'ordem_visualizacao' => 4]);
        Relatorio::create(['id' => 5, 'name' => 'Ferramentas', 'descricao' => '', 'ordem_visualizacao' => 5]);
        Relatorio::create(['id' => 6, 'name' => 'Segurança', 'descricao' => '', 'ordem_visualizacao' => 1]);

        //grupo_id=1
        GrupoRelatorio::create(['grupo_id' => 1, 'relatorio_id' => 1]);
        GrupoRelatorio::create(['grupo_id' => 1, 'relatorio_id' => 2]);
        GrupoRelatorio::create(['grupo_id' => 1, 'relatorio_id' => 3]);
        GrupoRelatorio::create(['grupo_id' => 1, 'relatorio_id' => 4]);
        GrupoRelatorio::create(['grupo_id' => 1, 'relatorio_id' => 5]);
        GrupoRelatorio::create(['grupo_id' => 1, 'relatorio_id' => 6]);
    }
}
