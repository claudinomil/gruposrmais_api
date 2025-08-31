<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEscalasTable extends Migration
{
    public function up()
    {
        Schema::create('escalas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->foreignId('escala_tipo_id')->nullable()->constrained('escala_tipos');
            $table->foreignId('escala_jornada_id')->nullable()->constrained('escala_jornadas');
            $table->string('tipo_name');
            $table->string('jornada_name');
            $table->string('quantidade_alas');
            $table->string('quantidade_horas');
            $table->integer('quantidade_integrantes')->nullable();
            $table->integer('quantidade_integrantes_ala')->nullable();
            $table->time('hora_inicio_ala')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('escalas');
    }
}
