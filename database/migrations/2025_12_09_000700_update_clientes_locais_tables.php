<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Renomeia a tabela primeiro
        Schema::rename('clientes_locais', 'estoques_locais');

        // Altera as colunas
        Schema::table('estoques_locais', function (Blueprint $table) {
            // Tenta remover a foreign key pelo nome antigo
            try {
                $table->dropForeign('clientes_locais_cliente_id_foreign');
            } catch (\Exception $e) {
                // ignora erro se a FK não existir
            }

            // Remove a coluna se existir
            if (Schema::hasColumn('estoques_locais', 'cliente_id')) {
                $table->dropColumn('cliente_id');
            }

            // Adiciona as novas colunas
            $table->foreignId('estoque_id')->constrained('estoques')->after('id');
            $table->foreignId('empresa_id')->nullable()->constrained('empresas')->after('estoque');
            $table->foreignId('cliente_id')->nullable()->constrained('clientes')->after('empresa_id');
        });
    }
};
