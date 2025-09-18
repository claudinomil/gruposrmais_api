<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEscalaTiposTable extends Migration
{
    public function up()
    {
        Schema::create('escala_tipos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('quantidade_alas');
            $table->integer('quantidade_horas_trabalhadas');
            $table->integer('quantidade_horas_descanso');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('escala_tipos');
    }
}
