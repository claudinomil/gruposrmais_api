<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('materiais_movimentacoes', function (Blueprint $table) {
            // Remover chave estrangeira e coluna
            $table->dropForeign('movimentacoes_materiais_material_id_foreign');
            $table->dropColumn('material_id');

            // Adicionar
            $table->foreignId('material_entrada_item_id')->constrained('materiais_entradas_itens');
        });
    }
};
