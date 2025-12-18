<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('materiais_movimentacoes', function (Blueprint $table) {
            // Remover chave estrangeira e coluna
            $table->dropForeign('materiais_movimentacoes_material_entrada_item_id_foreign');
            $table->dropColumn('material_entrada_item_id');

            $table->dropColumn('quantidade');
            $table->dropColumn('data_movimentacao');

            // Incluir campos
            $table->date('data_movimentacao');
            $table->time('hora_movimentacao');
        });
    }
};
