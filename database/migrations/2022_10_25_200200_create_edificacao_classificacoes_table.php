<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEdificacaoClassificacoesTable extends Migration
{
    public function up()
    {
        Schema::create('edificacao_classificacoes', function (Blueprint $table) {
            $table->id();
            $table->string('grupo');
            $table->string('ocupacao_uso');
            $table->string('divisao');
            $table->string('descricao');
            $table->text('definicao');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('edificacao_classificacoes');
    }
}
