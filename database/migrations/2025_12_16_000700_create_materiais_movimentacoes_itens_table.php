<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('materiais_movimentacoes_itens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_movimentacao_id')->constrained('materiais_movimentacoes');
            $table->foreignId('material_entrada_item_id')->constrained('materiais_entradas_itens');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('materiais_movimentacoes_itens');
    }
};
