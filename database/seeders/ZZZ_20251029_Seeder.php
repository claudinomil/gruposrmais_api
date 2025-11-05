<?php

namespace Database\Seeders;

use App\Models\Documento;
use Illuminate\Database\Seeder;

class ZZZ_20251029_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        //Documentos
        Documento::create(['id' => 42, 'name' => 'CPF', 'documento_submodulo_id' => 3, 'documento_fonte_id' => 2, 'ordem' => 140]);
        Documento::create(['id' => 43, 'name' => 'Representante Legal', 'documento_submodulo_id' => 3, 'documento_fonte_id' => 2, 'ordem' => 150]);
        Documento::create(['id' => 44, 'name' => 'Contrato Social', 'documento_submodulo_id' => 3, 'documento_fonte_id' => 2, 'ordem' => 160]);
        Documento::create(['id' => 45, 'name' => 'RGI', 'documento_submodulo_id' => 3, 'documento_fonte_id' => 2, 'ordem' => 170]);
        Documento::create(['id' => 46, 'name' => 'Contrato Locação', 'documento_submodulo_id' => 3, 'documento_fonte_id' => 2, 'ordem' => 180]);
        Documento::create(['id' => 47, 'name' => 'Comprovante de residência', 'documento_submodulo_id' => 3, 'documento_fonte_id' => 4, 'ordem' => 60]);
        Documento::create(['id' => 48, 'name' => 'Histórico escolar', 'documento_submodulo_id' => 3, 'documento_fonte_id' => 4, 'ordem' => 70]);
        Documento::create(['id' => 49, 'name' => 'Certidão de nascimento', 'documento_submodulo_id' => 3, 'documento_fonte_id' => 4, 'ordem' => 80]);
        Documento::create(['id' => 50, 'name' => 'Certidão de casamento', 'documento_submodulo_id' => 3, 'documento_fonte_id' => 4, 'ordem' => 90]);
        Documento::create(['id' => 51, 'name' => 'Título de eleitor', 'documento_submodulo_id' => 3, 'documento_fonte_id' => 4, 'ordem' => 100]);
        Documento::create(['id' => 52, 'name' => 'Certificado de Reservista', 'documento_submodulo_id' => 3, 'documento_fonte_id' => 4, 'ordem' => 110]);
        Documento::create(['id' => 53, 'name' => 'Antecedentes criminais', 'documento_submodulo_id' => 3, 'documento_fonte_id' => 4, 'ordem' => 120]);
        Documento::create(['id' => 54, 'name' => 'Dados Bancários', 'documento_submodulo_id' => 3, 'documento_fonte_id' => 4, 'ordem' => 130]);
        Documento::create(['id' => 55, 'name' => 'Dependentes', 'documento_submodulo_id' => 3, 'documento_fonte_id' => 4, 'ordem' => 140]);
        Documento::create(['id' => 56, 'name' => 'Certificado de Bombeiro Civil', 'documento_submodulo_id' => 3, 'documento_fonte_id' => 5, 'ordem' => 150]);
        Documento::create(['id' => 57, 'name' => 'Reciclagem de Bombeiro Civil', 'documento_submodulo_id' => 3, 'documento_fonte_id' => 5, 'ordem' => 160]);
        Documento::create(['id' => 58, 'name' => 'Homologação', 'documento_submodulo_id' => 3, 'documento_fonte_id' => 5, 'ordem' => 170]);
        Documento::create(['id' => 59, 'name' => 'NR 06', 'documento_submodulo_id' => 3, 'documento_fonte_id' => 5, 'ordem' => 180]);
        Documento::create(['id' => 60, 'name' => 'NR 10', 'documento_submodulo_id' => 3, 'documento_fonte_id' => 5, 'ordem' => 190]);
        Documento::create(['id' => 61, 'name' => 'NR 33', 'documento_submodulo_id' => 3, 'documento_fonte_id' => 5, 'ordem' => 200]);
        Documento::create(['id' => 62, 'name' => 'NR 20', 'documento_submodulo_id' => 3, 'documento_fonte_id' => 5, 'ordem' => 210]);
        Documento::create(['id' => 63, 'name' => 'NR 35', 'documento_submodulo_id' => 3, 'documento_fonte_id' => 5, 'ordem' => 220]);
        Documento::create(['id' => 64, 'name' => 'Atestado de Saúde Ocupacional', 'documento_submodulo_id' => 3, 'documento_fonte_id' => 5, 'ordem' => 230]);




    }
}