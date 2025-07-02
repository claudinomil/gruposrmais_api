<?php

namespace Database\Seeders;

use App\Models\Documento;
use App\Models\DocumentoFonte;
use App\Models\DocumentoSubmodulo;
use Illuminate\Database\Seeder;

class ZZZ_20250701_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        //Documento Submodulos
        DocumentoSubmodulo::create(['id' => 1, 'name' => 'CLIENTES']);
        DocumentoSubmodulo::create(['id' => 2, 'name' => 'FUNCIONÁRIOS']);
        DocumentoSubmodulo::create(['id' => 3, 'name' => 'CLIENTES EXECUTIVOS']);

        //Documento Fontes
        DocumentoFonte::create(['id' => 1, 'name' => 'PESSOA JURÍDICA', 'ordem' => 20]);
        DocumentoFonte::create(['id' => 2, 'name' => 'PESSOA FÍSICA', 'ordem' => 30]);
        DocumentoFonte::create(['id' => 3, 'name' => 'CORPO DE BOMBEIROS', 'ordem' => 10]);

        //Documentos
        Documento::create(['id' => 1, 'name' => 'Consulta Prévia', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 1, 'ordem' => 10]);
        Documento::create(['id' => 2, 'name' => 'CNPJ', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 1, 'ordem' => 20]);
        Documento::create(['id' => 3, 'name' => 'Representante Legal', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 1, 'ordem' => 30]);
        Documento::create(['id' => 4, 'name' => 'Contrato Social', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 1, 'ordem' => 40]);
        Documento::create(['id' => 5, 'name' => 'RGI', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 1, 'ordem' => 50]);
        Documento::create(['id' => 6, 'name' => 'Contrato Locação', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 1, 'ordem' => 60]);
        Documento::create(['id' => 7, 'name' => 'Apólice de Seguro', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 1, 'ordem' => 70]);
        Documento::create(['id' => 8, 'name' => 'Inscrição Estadual', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 1, 'ordem' => 80]);
        Documento::create(['id' => 9, 'name' => 'Inscrição Municipal', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 1, 'ordem' => 90]);
        Documento::create(['id' => 10, 'name' => 'Licenças Sanitárias', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 1, 'ordem' => 100]);
        Documento::create(['id' => 11, 'name' => 'Alvará de Funcionamento', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 1, 'ordem' => 110]);
        Documento::create(['id' => 12, 'name' => 'Memória Descritiva', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 1, 'ordem' => 120]);
        Documento::create(['id' => 13, 'name' => 'Certificado Funcionamento', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 1, 'ordem' => 130]);
        Documento::create(['id' => 14, 'name' => 'CPF', 'documento_submodulo_id' => 2, 'documento_fonte_id' => 2, 'ordem' => 140]);
        Documento::create(['id' => 15, 'name' => 'Representante Legal', 'documento_submodulo_id' => 2, 'documento_fonte_id' => 2, 'ordem' => 150]);
        Documento::create(['id' => 16, 'name' => 'Contrato Social', 'documento_submodulo_id' => 2, 'documento_fonte_id' => 2, 'ordem' => 160]);
        Documento::create(['id' => 17, 'name' => 'RGI', 'documento_submodulo_id' => 2, 'documento_fonte_id' => 2, 'ordem' => 170]);
        Documento::create(['id' => 18, 'name' => 'Contrato Locação', 'documento_submodulo_id' => 2, 'documento_fonte_id' => 2, 'ordem' => 180]);
        Documento::create(['id' => 19, 'name' => 'Projeto SCIP', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 3, 'ordem' => 190]);
        Documento::create(['id' => 20, 'name' => 'Laudo Exigências', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 3, 'ordem' => 200]);
        Documento::create(['id' => 21, 'name' => 'Certificado Aprovação', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 3, 'ordem' => 210]);
        Documento::create(['id' => 22, 'name' => 'Certificado Aprovação Simplificado', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 3, 'ordem' => 220]);
        Documento::create(['id' => 23, 'name' => 'Certificado Aprovação Assistido', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 3, 'ordem' => 230]);
    }
}
