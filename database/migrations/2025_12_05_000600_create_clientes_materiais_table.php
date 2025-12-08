<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesMateriaisTable extends Migration
{
    public function up()
    {
        Schema::create('clientes_materiais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->foreignId('cliente_local_id')->constrained('clientes_locais');
            $table->foreignId('material_id')->constrained('materiais');
            $table->decimal('quantidade', 12, 2);
            $table->date('data_entrada');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clientes_materiais');
    }
}
