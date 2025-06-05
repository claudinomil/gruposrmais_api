<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitasTecnicasDadosTable extends Migration
{
    public function up()
    {
        Schema::create('visitas_tecnicas_dados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visita_tecnica_id')->constrained('visitas_tecnicas');
            $table->integer('ordem');
            $table->string('titulo')->nullable();
            $table->string('subtitulo')->nullable();
            $table->text('pergunta');
            $table->text('respostas');
            $table->integer('resposta')->nullable();
            $table->text('observacao')->nullable();
            $table->text('fotografia_1')->nullable();
            $table->text('fotografia_2')->nullable();
            $table->text('fotografia_3')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('visitas_tecnicas_dados');
    }
}
