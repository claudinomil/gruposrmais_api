<?php

namespace Database\Seeders;

use App\Models\MedidaSeguranca;
use Illuminate\Database\Seeder;

class MedidasSegurancaSeeder extends Seeder
{
    public function run()
    {
        MedidaSeguranca::create(['name' => 'Acesso de viaturas']); //1
        MedidaSeguranca::create(['name' => 'Alarme de incêndio']); //2
        MedidaSeguranca::create(['name' => 'Aparelho extintor']); //3
        MedidaSeguranca::create(['name' => 'Brigada de incêndio']); //4
        MedidaSeguranca::create(['name' => 'Chuveiro automático']); //5
        MedidaSeguranca::create(['name' => 'Compartimentação horizontal']); //6
        MedidaSeguranca::create(['name' => 'Compartimentação vertical']); //7
        MedidaSeguranca::create(['name' => 'Segurança estrutural contra incêndio']); //8
        MedidaSeguranca::create(['name' => 'Controle de fumaça']); //9
        MedidaSeguranca::create(['name' => 'Controle de materiais de acabamento e revestimento']); //10
        MedidaSeguranca::create(['name' => 'Detecção de incêndio']); //11
        MedidaSeguranca::create(['name' => 'Elevador de emergência']); //12
        MedidaSeguranca::create(['name' => 'Escada de emergência']); //13
        MedidaSeguranca::create(['name' => 'Hidrante urbano do tipo coluna']); //14
        MedidaSeguranca::create(['name' => 'Hidrante e mangotinho']); //15
        MedidaSeguranca::create(['name' => 'Iluminação de emergência']); //16
        MedidaSeguranca::create(['name' => 'Plano de emergência contra incêndio e pânico']); //17
        MedidaSeguranca::create(['name' => 'Saídas de emergência']); //18
        MedidaSeguranca::create(['name' => 'Separação entre edificações']); //19
        MedidaSeguranca::create(['name' => 'Sinalização de segurança contra incêndio e pânico']); //20
        MedidaSeguranca::create(['name' => 'Sistema de espuma']); //21
        MedidaSeguranca::create(['name' => 'Sistema de proteção contra descargas atmosféricas']); //22
        MedidaSeguranca::create(['name' => 'Sistema de resfriamento']); //23
        MedidaSeguranca::create(['name' => 'Sistema fixo de gases para combate a incêndio']); //24
    }
}
