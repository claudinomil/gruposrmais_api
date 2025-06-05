<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitaTecnicaPerguntasTable extends Migration
{
    public function up()
    {
        Schema::create('visita_tecnica_perguntas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visita_tecnica_tipo_id')->constrained('visita_tecnica_tipos');
            $table->integer('ordem');
            $table->string('titulo')->nullable();
            $table->string('subtitulo')->nullable();
            $table->text('pergunta');
            $table->text('respostas');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('visita_tecnica_perguntas');
    }
}
