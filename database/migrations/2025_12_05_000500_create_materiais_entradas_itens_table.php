<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMateriaisEntradasItensTable extends Migration
{
    public function up()
    {
        Schema::create('materiais_entradas_itens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_entrada_id')->constrained('materiais_entradas');
            $table->foreignId('material_id')->constrained('materiais');
            $table->string('material_categoria_name');
            $table->string('material_name');
            $table->decimal('material_quantidade', 12, 2);
            $table->decimal('material_valor_unitario', 12, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('materiais_entradas_itens');
    }
}
