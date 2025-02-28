<?php

namespace Database\Seeders;

use App\Models\SegurancaMedida;
use Illuminate\Database\Seeder;

class SegurancaMedidasSeeder extends Seeder
{
    public function run()
    {
        SegurancaMedida::create(['name' => 'Acesso de viaturas']); //1
        SegurancaMedida::create(['name' => 'Alarme de incêndio']); //2
        SegurancaMedida::create(['name' => 'Aparelho extintor']); //3
        SegurancaMedida::create(['name' => 'Brigada de incêndio']); //4
        SegurancaMedida::create(['name' => 'Chuveiro automático']); //5
        SegurancaMedida::create(['name' => 'Compartimentação horizontal']); //6
        SegurancaMedida::create(['name' => 'Compartimentação vertical']); //7
        SegurancaMedida::create(['name' => 'Segurança estrutural contra incêndio']); //8
        SegurancaMedida::create(['name' => 'Controle de fumaça']); //9
        SegurancaMedida::create(['name' => 'Controle de materiais de acabamento e revestimento']); //10
        SegurancaMedida::create(['name' => 'Detecção de incêndio']); //11
        SegurancaMedida::create(['name' => 'Elevador de emergência']); //12
        SegurancaMedida::create(['name' => 'Escada de emergência']); //13
        SegurancaMedida::create(['name' => 'Hidrante urbano do tipo coluna']); //14
        SegurancaMedida::create(['name' => 'Hidrante e mangotinho']); //15
        SegurancaMedida::create(['name' => 'Iluminação de emergência']); //16
        SegurancaMedida::create(['name' => 'Plano de emergência contra incêndio e pânico']); //17
        SegurancaMedida::create(['name' => 'Saídas de emergência']); //18
        SegurancaMedida::create(['name' => 'Separação entre edificações']); //19
        SegurancaMedida::create(['name' => 'Sinalização de segurança contra incêndio e pânico']); //20
        SegurancaMedida::create(['name' => 'Sistema de espuma']); //21
        SegurancaMedida::create(['name' => 'Sistema de proteção contra descargas atmosféricas']); //22
        SegurancaMedida::create(['name' => 'Sistema de resfriamento']); //23
        SegurancaMedida::create(['name' => 'Sistema fixo de gases para combate a incêndio']); //24
    }
}
