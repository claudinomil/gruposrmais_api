<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveDataInicioDataFimFromMapasPontosInteresseTable extends Migration
{
    public function up()
    {
        Schema::table('mapas_pontos_interesse', function (Blueprint $table) {
            $table->dropColumn(['data_inicio', 'data_fim']);
        });
    }

    public function down()
    {
        Schema::table('mapas_pontos_interesse', function (Blueprint $table) {
            $table->date('data_inicio')->nullable();  // Coloque nullable se quiser evitar problemas.
            $table->date('data_fim')->nullable();
        });
    }
}
