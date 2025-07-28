<?php

namespace Database\Seeders;

use App\Models\Grupo;
use App\Models\GrupoPermissao;
use App\Models\GrupoRelatorio;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ZZZ_20250721_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        //Varrer users para gravar campos de configurações''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        $users = User::all();

        foreach ($users as $user) {
            $grupo_id = 3;
            $situacao_id = 1;
            $layout_mode = 'layout_mode_light';
            $layout_style = 'layout_style_vertical_scrollable';

            if ($user->id == 1 or $user->id == 2) {$grupo_id = 1;}

            $user->grupo_id = $grupo_id;
            $user->situacao_id = $situacao_id;
            $user->layout_mode = $layout_mode;
            $user->layout_style = $layout_style;

            $user->save();
        }
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Varrer grupos para deletar registros nas tabelas grupos_permissoes, grupos_relatorios e grupos''''''''''''''''
        $grupos = Grupo::all();

        foreach ($grupos as $grupo) {
            if ($grupo->empresa_id == 2 or $grupo->empresa_id == 3) {
                GrupoPermissao::where('grupo_id', $grupo->id)->delete();
                GrupoRelatorio::where('grupo_id', $grupo->id)->delete();

                $grupo->delete();
            }
        }
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Deletar campo empresa_id da tabela grupos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Schema::table('grupos', function (Blueprint $table) {
            $table->dropForeign(['empresa_id']);
            $table->dropColumn('empresa_id');
        });
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
