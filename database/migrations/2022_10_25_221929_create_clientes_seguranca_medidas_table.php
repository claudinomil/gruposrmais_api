<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesSegurancaMedidasTable extends Migration
{
    public function up()
    {
        Schema::create('clientes_seguranca_medidas', function (Blueprint $table) {
            $table->id();
            $table->integer('pavimento');
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->foreignId('seguranca_medida_id')->constrained('seguranca_medidas');
            $table->integer('quantidade')->nullable();
            $table->string('tipo')->nullable();
            $table->text('observacao')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clientes_seguranca_medidas');
    }
}
