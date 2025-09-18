<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrigadasIncendiosEscalasGeradasDadosTable extends Migration
{
    public function up()
    {
        Schema::create('brigadas_incendios_escalas_geradas_dados', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('brigada_incendio_escala_id')->constrained('brigadas_incendios_escalas')->index('bied_brigada_incendio_escala_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('brigadas_incendios_escalas_geradas_dados');
    }
}