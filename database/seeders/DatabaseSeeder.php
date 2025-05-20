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
            ServicoStatusSeeder::class,
            EscalaFrequenciasSeeder::class,
            LayoutsModesSeeder::class,
            LayoutsStylesSeeder::class,
            FuncionariosSeeder::class,

            Z_RealSeeder::class,

            ZZZ_20250315_Seeder::class,
            ZZZ_20250428_Seeder::class,
            ZZZ_20250502_Seeder::class,
            ZZZ_20250517_Seeder::class,

            Z_FakerSeeder::class
        ]);
    }
}
