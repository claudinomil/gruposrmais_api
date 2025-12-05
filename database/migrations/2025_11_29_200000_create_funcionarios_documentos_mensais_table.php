<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuncionariosDocumentosMensaisTable extends Migration
{
    public function up()
    {
        Schema::create('funcionarios_documentos_mensais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('funcionario_id')->constrained('funcionarios');
            $table->foreignId('documento_mensal_funcionario_id')->constrained('documentos_mensais_funcionarios')->name('fk_doc_mensal_func');
            $table->string('mes', 2);
            $table->string('ano', 4);
            $table->string('caminho');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('funcionarios_documentos_mensais');
    }
}
