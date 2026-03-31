<?php

namespace Database\Seeders;

use App\Models\Documento;
use App\Models\DocumentoFonte;
use App\Models\EquipamentoPreventivo;
use App\Models\Modulo;
use App\Models\Submodulo;
use App\Models\Permissao;
use App\Models\GrupoPermissao;

use Illuminate\Database\Seeder;

class ZZZ_20260329_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        // Submódulo Equipamentos Preventivos''''''''''''''''''''''''''''''''''''''''

        // Criar Submódulo
        Submodulo::create(['id' => 51, 'modulo_id' => 11, 'name' => 'Equipamentos Preventivos', 'menu_text' => 'Equipamentos Preventivos', 'menu_url' => 'equipamentos_preventivos', 'menu_route' => 'equipamentos_preventivos', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'equipamentos_preventivos', 'prefix_route' => 'equipamentos_preventivos', 'mobile' => 0, 'menu_text_mobile' => 'Meus ', 'viewing_order' => 6]);

        // Criar Permissões
        Permissao::create(['id' => 236, 'submodulo_id' => 51, 'name' => 'equipamentos_preventivos_list', 'description' => 'Visualizar Registro - Equipamentos Preventivos']);
        Permissao::create(['id' => 237, 'submodulo_id' => 51, 'name' => 'equipamentos_preventivos_create', 'description' => 'Criar Registro - Equipamentos Preventivos']);
        Permissao::create(['id' => 238, 'submodulo_id' => 51, 'name' => 'equipamentos_preventivos_show', 'description' => 'Visualizar Registro - Equipamentos Preventivos']);
        Permissao::create(['id' => 239, 'submodulo_id' => 51, 'name' => 'equipamentos_preventivos_edit', 'description' => 'Editar Registro - Equipamentos Preventivos']);
        Permissao::create(['id' => 240, 'submodulo_id' => 51, 'name' => 'equipamentos_preventivos_destroy', 'description' => 'Deletar Registro - Equipamentos Preventivos']);

        // Criar Grupo Permissão (COLOQUEI NO Z_Faker7Seeder)
        // GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 236]);
        // GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 237]);
        // GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 238]);
        // GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 239]);
        // GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 240]);
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo Sistemas Preventivos''''''''''''''''''''''''''''''''''''''''''''

        // Criar Submódulo
        Submodulo::create(['id' => 49, 'modulo_id' => 11, 'name' => 'Sistemas Preventivos', 'menu_text' => 'Sistemas Preventivos', 'menu_url' => 'sistemas_preventivos', 'menu_route' => 'sistemas_preventivos', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'sistemas_preventivos', 'prefix_route' => 'sistemas_preventivos', 'mobile' => 0, 'menu_text_mobile' => 'Meus ', 'viewing_order' => 7]);

        // Criar Permissões
        Permissao::create(['id' => 226, 'submodulo_id' => 49, 'name' => 'sistemas_preventivos_list', 'description' => 'Visualizar Registro - Sistemas Preventivos']);
        Permissao::create(['id' => 227, 'submodulo_id' => 49, 'name' => 'sistemas_preventivos_create', 'description' => 'Criar Registro - Sistemas Preventivos']);
        Permissao::create(['id' => 228, 'submodulo_id' => 49, 'name' => 'sistemas_preventivos_show', 'description' => 'Visualizar Registro - Sistemas Preventivos']);
        Permissao::create(['id' => 229, 'submodulo_id' => 49, 'name' => 'sistemas_preventivos_edit', 'description' => 'Editar Registro - Sistemas Preventivos']);
        Permissao::create(['id' => 230, 'submodulo_id' => 49, 'name' => 'sistemas_preventivos_destroy', 'description' => 'Deletar Registro - Sistemas Preventivos']);

        // Criar Grupo Permissão (COLOQUEI NO Z_Faker7Seeder)
        // GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 226]);
        // GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 227]);
        // GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 228]);
        // GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 229]);
        // GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 230]);
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Equipamentos Preventivos''''''''''''''''''''''''''''''''''''''''''''''''''
        $equipamentos = [
            'Extintor de Água (Classe A)',
            'Extintor de Pó Químico Seco - PQS (Classe BC)',
            'Extintor de Pó Químico Seco - PQS (Classe ABC)',
            'Extintor de CO2',
            'Extintor de Espuma Mecânica',
            'Extintor Classe K',
            'Hidrante de Parede',
            'Hidrante de Recalque',
            'Abrigo de Hidrante',
            'Mangueira Tipo 1',
            'Mangueira Tipo 2',
            'Esguicho Regulável',
            'Esguicho Jato Sólido',
            'Chave Storz',
            'Adaptador Storz',
            'Detector de Fumaça',
            'Detector de Calor',
            'Acionador Manual',
            'Luminária de Emergência',
            'Porta Corta-Fogo',
            'Barra Antipânico',
            'Sprinkler'
        ];

        foreach ($equipamentos as $nome) {
            EquipamentoPreventivo::create(['name' => $nome]);
        }
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Documentos''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Documento Fontes
        DocumentoFonte::create(['id' => 9, 'name' => 'PROJETOS', 'ordem' => 15]);

        // Documentos
        Documento::create(['id' => 99, 'name' => 'Projeto de Arquitetura', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 9, 'ordem' => 10]);
        Documento::create(['id' => 100, 'name' => 'Projeto de Instalações Elétricas', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 9, 'ordem' => 40]);
        Documento::create(['id' => 101, 'name' => 'Projeto de Climatização', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 9, 'ordem' => 60]);
        Documento::create(['id' => 102, 'name' => 'Projeto de Exaustão Mecânica', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 9, 'ordem' => 70]);
        Documento::create(['id' => 103, 'name' => 'Projeto de Gás (GLP / GN)', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 9, 'ordem' => 80]);
        Documento::create(['id' => 104, 'name' => 'Projeto de SPDA', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 9, 'ordem' => 130]);
        Documento::create(['id' => 105, 'name' => 'Projeto Hidrossanitário', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 9, 'ordem' => 50]);
        Documento::create(['id' => 106, 'name' => 'Projeto Estrutural', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 9, 'ordem' => 20]);
        Documento::create(['id' => 107, 'name' => 'Projeto de CFTV', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 9, 'ordem' => 90]);
        Documento::create(['id' => 108, 'name' => 'Projeto de Controle de Acesso', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 9, 'ordem' => 110]);
        Documento::create(['id' => 109, 'name' => 'Projeto de Automação', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 9, 'ordem' => 120]);
        Documento::create(['id' => 110, 'name' => 'Projeto de Rede de Dados', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 9, 'ordem' => 100]);
        Documento::create(['id' => 111, 'name' => 'Projeto de As Built', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 9, 'ordem' => 30]);
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
