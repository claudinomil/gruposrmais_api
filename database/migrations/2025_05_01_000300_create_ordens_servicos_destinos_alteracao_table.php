<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdensServicosDestinosAlteracaoTable extends Migration
{
    public function up()
    {
        Schema::table('ordens_servicos_destinos', function (Blueprint $table) {
            $table->date('destino_data_agendada')->nullable();
            $table->time('destino_hora_agendada')->nullable();
            $table->date('destino_data_inicio')->nullable();
            $table->time('destino_hora_inicio')->nullable();
            $table->date('destino_data_termino')->nullable();
            $table->time('destino_hora_termino')->nullable();
        });
    }

    public function down()
    {
        Schema::table('ordens_servicos_destinos', function (Blueprint $table) {
            $table->dropColumn(['destino_data_agendada']);
            $table->dropColumn(['destino_hora_agendada']);
            $table->dropColumn(['destino_data_inicio']);
            $table->dropColumn(['destino_hora_inicio']);
            $table->dropColumn(['destino_data_termino']);
            $table->dropColumn(['destino_hora_termino']);
        });
    }
}
