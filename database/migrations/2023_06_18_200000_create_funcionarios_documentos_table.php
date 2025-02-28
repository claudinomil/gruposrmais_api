<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuncionariosDocumentosTable extends Migration
{
    public function up()
    {
        Schema::create('funcionarios_documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('funcionario_id')->constrained('funcionarios');
            $table->string('name');
            $table->string('descricao');
            $table->string('caminho');
            $table->date('data_documento')->nullable();
            $table->integer('aviso');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('funcionarios_documentos');
    }
}
