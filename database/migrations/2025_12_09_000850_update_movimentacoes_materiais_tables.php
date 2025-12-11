<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Renomeia a tabela primeiro
        Schema::rename('movimentacoes_materiais', 'materiais_movimentacoes');

        Schema::table('materiais_movimentacoes', function (Blueprint $table) {
            // Remover colunas antigas (se existirem)
            if (Schema::hasColumn('materiais_movimentacoes', 'origem_cliente_id')) {
                $table->dropColumn(['origem_cliente_id', 'origem_local_id', 'destino_cliente_id', 'destino_local_id']);
            }

            // Adicionar
            $table->foreignId('origem_estoque_local_id')->after('material_id')->constrained('estoques_locais');
            $table->foreignId('destino_estoque_local_id')->after('origem_estoque_local_id')->constrained('estoques_locais');
        });
    }
};
