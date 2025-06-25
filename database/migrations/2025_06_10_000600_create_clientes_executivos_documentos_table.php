<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesExecutivosDocumentosTable extends Migration
{
    public function up()
    {
        Schema::create('clientes_executivos_documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_executivo_id')->constrained('clientes_executivos');
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
        Schema::dropIfExists('clientes_executivos_documentos');
    }
}
