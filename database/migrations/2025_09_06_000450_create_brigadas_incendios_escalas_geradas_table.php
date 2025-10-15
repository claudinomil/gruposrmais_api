<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrigadasIncendiosEscalasGeradasTable extends Migration
{
    public function up()
    {
        Schema::create('brigadas_incendios_escalas_geradas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brigada_incendio_id')->constrained('brigadas_incendios');
            $table->date('data_inicio');
            $table->date('data_termino');

            // Dados vindos da tabela brigadas_incendios_escalas
            $table->string('escala_tipo_name');
            $table->integer('escala_tipo_quantidade_alas');
            $table->integer('escala_tipo_quantidade_horas_trabalhadas');
            $table->integer('escala_tipo_quantidade_horas_descanso');
            $table->integer('quantidade_brigadistas_por_ala');
            $table->integer('quantidade_brigadistas_total');
            $table->string('posto');
            $table->time('hora_inicio_ala_1');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('brigadas_incendios_escalas_geradas');
    }
}