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
            // $table->foreignId('brigada_incendio_id')->constrained('brigadas_incendios');
            // $table->foreignId('escala_tipo_id')->constrained('escala_tipos');
            // $table->date('data_inicio');
            // $table->date('data_termino');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('brigadas_incendios_escalas_geradas');
    }
}