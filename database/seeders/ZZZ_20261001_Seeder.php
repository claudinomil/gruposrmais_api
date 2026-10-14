<?php

namespace Database\Seeders;

use App\Models\Documento;
use App\Models\DocumentoFonte;
use App\Models\Uniforme;
use Illuminate\Database\Seeder;

class ZZZ_20261001_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        // Uniformes'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Uniforme::create(['id' => 1, 'name' => 'GANDOLA', 'funcionarios_campo' => 'uniforme_gandola']);
        Uniforme::create(['id' => 2, 'name' => 'BLUSA', 'funcionarios_campo' => 'uniforme_blusa']);
        Uniforme::create(['id' => 3, 'name' => 'CALÇA', 'funcionarios_campo' => 'uniforme_calca']);
        Uniforme::create(['id' => 4, 'name' => 'COTURNO', 'funcionarios_campo' => 'uniforme_coturno']);
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Documentos''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Documento Fontes
        DocumentoFonte::create(['id' => 10, 'name' => 'Relatórios e Certificados', 'ordem' => 90]);

        // Documentos
        Documento::create(['id' => 113, 'name' => 'RELATÓRIO DE MAPEAMENTO DE RISCOS', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 10, 'ordem' => 10]);
        Documento::create(['id' => 114, 'name' => 'RELATÓRIO DE RECOMENDAÇÕES / GERENCIAMENTO DE RISCOS', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 10, 'ordem' => 20]);
        Documento::create(['id' => 115, 'name' => 'RELATÓRIO DE VISTORIA TÉCNICA', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 10, 'ordem' => 30]);
        Documento::create(['id' => 116, 'name' => 'RELATÓRIO DE INSPEÇÃO TÉCNICA', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 10, 'ordem' => 40]);
        Documento::create(['id' => 117, 'name' => 'RELATÓRIO DE ANÁLISE DE RISCOS', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 10, 'ordem' => 50]);
        Documento::create(['id' => 118, 'name' => 'RELATÓRIO DE MANUTENÇÃO PREVENTIVA / CORRETIVA', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 10, 'ordem' => 60]);
        Documento::create(['id' => 119, 'name' => 'RELATÓRIO DE SIMULADO DE ABANDONO', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 10, 'ordem' => 70]);
        Documento::create(['id' => 120, 'name' => 'RELATÓRIO DE TREINAMENTO / CAPACITAÇÃO', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 10, 'ordem' => 80]);
        Documento::create(['id' => 121, 'name' => 'CERTIFICADO DE TREINAMENTO', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 10, 'ordem' => 90]);
        Documento::create(['id' => 122, 'name' => 'CERTIFICADO DE BRIGADA DE INCÊNDIO', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 10, 'ordem' => 100]);
        Documento::create(['id' => 123, 'name' => 'CERTIFICADO DE MANUTENÇÃO', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 10, 'ordem' => 110]);
        Documento::create(['id' => 124, 'name' => 'CERTIFICADO DE INSPEÇÃO / TESTE', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 10, 'ordem' => 120]);
        Documento::create(['id' => 125, 'name' => 'CERTIFICADO DE GARANTIA', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 10, 'ordem' => 130]);
        Documento::create(['id' => 126, 'name' => 'OUTROS RELATÓRIOS E CERTIFICADOS', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 10, 'ordem' => 140]);
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
