<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrigadasRondasTable extends Migration
{
    public function up()
    {
        Schema::create('brigadas_rondas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('brigada_escala_id')->constrained('brigadas_escalas');

            $table->longText('foto')->nullable();
            $table->date('data_inicio_ronda')->nullable();
            $table->time('hora_inicio_ronda')->nullable();
            $table->date('data_encerramento_ronda')->nullable();
            $table->time('hora_encerramento_ronda')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('brigadas_rondas');
    }
}
