<?php

namespace Database\Seeders;

use App\Models\Documento;
use App\Models\DocumentoFonte;
use App\Models\Submodulo;
use App\Models\Permissao;
use App\Models\GrupoPermissao;
use App\Models\VistoriaSistemaStatus;
use Illuminate\Database\Seeder;

class ZZZ_20260227_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        // Submódulo Vistorias Sistemas''''''''''''''''''''''''''''''''''''''''''''''

        // Criar Submódulo
        Submodulo::create(['id' => 50, 'modulo_id' => 8, 'name' => 'Vistorias Sistemas', 'menu_text' => 'Vistorias Sistemas', 'menu_url' => 'vistorias_sistemas', 'menu_route' => 'vistorias_sistemas', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'vistorias_sistemas', 'prefix_route' => 'vistorias_sistemas', 'mobile' => 1, 'menu_text_mobile' => 'Meus ', 'viewing_order' => 50]);

        // Criar Permissões
        Permissao::create(['id' => 231, 'submodulo_id' => 50, 'name' => 'vistorias_sistemas_list', 'description' => 'Visualizar Registro - Vistorias Sistemas']);
        Permissao::create(['id' => 232, 'submodulo_id' => 50, 'name' => 'vistorias_sistemas_create', 'description' => 'Criar Registro - Vistorias Sistemas']);
        Permissao::create(['id' => 233, 'submodulo_id' => 50, 'name' => 'vistorias_sistemas_show', 'description' => 'Visualizar Registro - Vistorias Sistemas']);
        Permissao::create(['id' => 234, 'submodulo_id' => 50, 'name' => 'vistorias_sistemas_edit', 'description' => 'Editar Registro - Vistorias Sistemas']);
        Permissao::create(['id' => 235, 'submodulo_id' => 50, 'name' => 'vistorias_sistemas_destroy', 'description' => 'Deletar Registro - Vistorias Sistemas']);

        // Criar Grupo Permissão
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 231]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 232]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 233]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 234]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 235]);
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Vistoria Sistema Status
        VistoriaSistemaStatus::create(['id' => 1, 'name' => 'ABERTA']);
        VistoriaSistemaStatus::create(['id' => 2, 'name' => 'EM ANDAMENTO']);
        VistoriaSistemaStatus::create(['id' => 3, 'name' => 'CONCLUÍDA']);
        VistoriaSistemaStatus::create(['id' => 4, 'name' => 'FINALIZADA']);
        VistoriaSistemaStatus::create(['id' => 5, 'name' => 'CANCELADA']);
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Documento Fontes e Documentos'''''''''''''''''''''''''''''''''''''''''''''

        // Documento Fontes Alterar
        DocumentoFonte::where('id', 6)->update(['name' => 'ANOTAÇÕES DE RESPONSABILIDADE TÉCNICA - INSPEÇÃO, TESTES E MANUTENÇÃO']);

        // Documentos Alterar
        Documento::where('id', 71)->update(['name' => 'ART do sistema de controle de fumaça e calor, quando existente (inspeção, testes e manutenção)']);
        Documento::where('id', 72)->update(['name' => 'ART do sistema de pressurização de escadas, quando aplicável (inspeção, testes e manutenção)']);
        Documento::where('id', 74)->update(['name' => 'ART e nota fiscal de inspeção e manutenção de extintores de incêndio (inspeção, testes e manutenção)']);
        Documento::where('id', 75)->update(['name' => 'Contrato de prestação de serviços da Brigada de Incêndio, quando aplicável (inspeção, testes e manutenção)']);
        Documento::where('id', 76)->update(['name' => 'ART de responsável técnico pela edificação, quando aplicável (inspeção, testes e manutenção)']);

        // Documento Fontes Incluir
        DocumentoFonte::create(['id' => 8, 'name' => 'ANOTAÇÕES DE RESPONSABILIDADE TÉCNICA - INSTALAÇÃO', 'ordem' => 55]);

        // Documento Fontes Alterar
        DocumentoFonte::where('id', 1)->update(['ordem' => 10]);
        DocumentoFonte::where('id', 3)->update(['ordem' => 20]);

        // Documentos Incluir
        Documento::create(['id' => 87, 'name' => 'ART do sistema da rede de hidrantes da rede de hidrantes e mangotinhos (intalação)', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 8, 'ordem' => 240]);
        Documento::create(['id' => 88, 'name' => 'ART do sistema de bombas de incêndio (intalação)', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 8, 'ordem' => 250]);
        Documento::create(['id' => 89, 'name' => 'ART do sistema de sprinklers (intalação)', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 8, 'ordem' => 260]);
        Documento::create(['id' => 90, 'name' => 'ART do sistema de detecção e alarme de incêndio (intalação)', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 8, 'ordem' => 270]);
        Documento::create(['id' => 91, 'name' => 'ART do sistema de iluminação de emergência (intalação)', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 8, 'ordem' => 280]);
        Documento::create(['id' => 92, 'name' => 'ART do Sistema de Proteção contra Descargas Atmosféricas (SPDA) (intalação)', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 8, 'ordem' => 290]);
        Documento::create(['id' => 93, 'name' => 'ART do sistema de controle de fumaça e calor, quando existente (intalação)', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 8, 'ordem' => 300]);
        Documento::create(['id' => 94, 'name' => 'ART do sistema de pressurização de escadas, quando aplicável (intalação)', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 8, 'ordem' => 310]);
        Documento::create(['id' => 95, 'name' => 'ART do sistema de gás (GLP ou GN), incluindo estanqueidade e segurança (intalação)', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 8, 'ordem' => 320]);
        Documento::create(['id' => 96, 'name' => 'ART e nota fiscal de inspeção e manutenção de extintores de incêndio (intalação)', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 8, 'ordem' => 330]);
        Documento::create(['id' => 97, 'name' => 'Contrato de prestação de serviços da Brigada de Incêndio, quando aplicável (intalação)', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 8, 'ordem' => 340]);
        Documento::create(['id' => 98, 'name' => 'ART de responsável técnico pela edificação, quando aplicável (intalação)', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 8, 'ordem' => 350]);
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
