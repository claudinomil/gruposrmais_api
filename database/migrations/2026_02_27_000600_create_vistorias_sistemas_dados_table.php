<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vistorias_sistemas_dados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vistoria_sistema_id')->constrained('vistorias_sistemas');
            $table->string('titulo')->nullable();
            $table->string('subtitulo')->nullable();
            $table->text('pergunta');
            $table->integer('resposta')->nullable();
            $table->text('observacao')->nullable();
            $table->text('fotografia_1')->nullable();
            $table->text('fotografia_2')->nullable();
            $table->text('fotografia_3')->nullable();
            $table->integer('quantidade')->default(0);
            $table->text('pdf_1')->nullable();
            $table->text('pdf_2')->nullable();
            $table->text('pdf_3')->nullable();
            $table->integer('completa')->default(0);
            $table->integer('completa_ordem')->default(0);
            $table->integer('sintetica')->default(0);
            $table->integer('sintetica_ordem')->default(0);
            $table->integer('opcoes')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vistorias_sistemas_dados');
    }
};
