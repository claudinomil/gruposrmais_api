<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            EmpresasSeeder::class,
            ModulosSeeder::class,
            SubmodulosSeeder::class,
            GenerosSeeder::class,
            ContratacaoTiposSeeder::class,
            PixTiposSeeder::class,
            ServicoTiposSeeder::class,
            ServicosSeeder::class,
            EstadosCivisSeeder::class,
            IdentidadeOrgaosSeeder::class,
            NacionalidadesSeeder::class,
            NaturalidadesSeeder::class,
            EscolaridadesSeeder::class,
            TelefoneDddsSeeder::class,
            TelefoneDdisSeeder::class,
            GruposSeeder::class,
            IconsSeeder::class,
            PermissoesSeeder::class,
            GrupoPermissoesSeeder::class,
            SituacoesSeeder::class,
            OperacoesSeeder::class,
            SistemaAcessosSeeder::class,
            EstadosSeeder::class,
            UsersSeeder::class,
            SegurancaMedidasSeeder::class,
            EdificacaoClassificacoesSeeder::class,
            IncendioRiscosSeeder::class,
            BancosSeeder::class,
            DepartamentosSeeder::class,
            FuncoesSeeder::class,
            EscalaTiposSeeder::class,
            EscalaFrequenciasSeeder::class,
            ServicoStatusSeeder::class,
            LayoutsModesSeeder::class,
            LayoutsStylesSeeder::class,
            FuncionariosSeeder::class,

            Z_RealSeeder::class,

            ZZZ_20250315_Seeder::class,
            ZZZ_20250428_Seeder::class,
            ZZZ_20250502_Seeder::class,
            ZZZ_20250517_Seeder::class,
            ZZZ_20250529_Seeder::class,
            ZZZ_20250615_Seeder::class,
            ZZZ_20250701_Seeder::class,
            ZZZ_20250706_Seeder::class,

            Z_FakerSeeder::class,

            ZZZ_20250706_Seeder::class,
            ZZZ_20250721_Seeder::class
        ]);
    }
}
