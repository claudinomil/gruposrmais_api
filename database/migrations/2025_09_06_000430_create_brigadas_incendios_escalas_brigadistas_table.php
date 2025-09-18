<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrigadasIncendiosEscalasBrigadistasTable extends Migration
{
    public function up()
    {
        Schema::create('brigadas_incendios_escalas_brigadistas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brigada_incendio_escala_id')->constrained('brigadas_incendios_escalas')->index('bieb_brigada_incendio_escala_id');
            
            $table->foreignId('funcionario_id')->constrained('funcionarios');
            $table->string('funcionario_name');
            $table->string('ala');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('brigadas_incendios_escalas_brigadistas');
    }
}