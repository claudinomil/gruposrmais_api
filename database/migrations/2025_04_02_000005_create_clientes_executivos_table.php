<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesExecutivosTable extends Migration
{
    public function up()
    {
        Schema::create('clientes_executivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->string('executivo_nome');
            $table->string('executivo_funcao');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clientes_executivos');
    }
}
