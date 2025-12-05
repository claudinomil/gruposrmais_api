<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosMensaisFuncionariosTable extends Migration
{
    public function up()
    {
        Schema::create('documentos_mensais_funcionarios', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('ordem');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('documentos_mensais_funcionarios');
    }
}
