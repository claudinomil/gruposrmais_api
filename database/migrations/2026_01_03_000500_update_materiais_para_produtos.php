<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // MUDANDO TUDO QUE USA MATERIAL/MATERIAIS PARA PRODUTO/PRODUTOS

        // Tabela: material_situacoes ''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Schema::rename('material_situacoes', 'produto_situacoes');
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Tabela: material_categorias '''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Schema::rename('material_categorias', 'produto_categorias');
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Tabela: materiais '''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // 1. Renomear a tabela mantendo os dados
        Schema::rename('materiais', 'produtos');

        // 2. Renomear colunas (mantém os dados)
        Schema::table('produtos', function (Blueprint $table) {
            $table->renameColumn('material_categoria_id', 'produto_categoria_id');
        });

        // 3. Adicionar as novas FKs (após renomear colunas)
        Schema::table('produtos', function (Blueprint $table) {
            $table->foreign('produto_categoria_id', 'p_prod_cat')->references('id')->on('produtos');
        });
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Tabela: materiais_entradas ''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Schema::rename('materiais_entradas', 'produtos_entradas');
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Tabela: materiais_entradas_itens ''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // 1. Renomear a tabela mantendo os dados
        Schema::rename('materiais_entradas_itens', 'produtos_entradas_itens');

        // 2. Renomear colunas (mantém os dados)
        Schema::table('produtos_entradas_itens', function (Blueprint $table) {
            $table->renameColumn('material_entrada_id', 'produto_entrada_id');
            $table->renameColumn('material_id', 'produto_id');
            $table->renameColumn('material_categoria_name', 'produto_categoria_name');
            $table->renameColumn('material_name', 'produto_name');
            $table->renameColumn('material_valor_unitario', 'produto_valor_unitario');
            $table->renameColumn('material_numero_patrimonio', 'produto_numero_patrimonio');
            $table->renameColumn('material_situacao_id', 'produto_situacao_id');
        });

        // 3. Adicionar as novas FKs (após renomear colunas)
        Schema::table('produtos_entradas_itens', function (Blueprint $table) {
            $table->foreign('produto_entrada_id', 'pei_prod_ent')->references('id')->on('produtos_entradas');
            $table->foreign('produto_id', 'pei_prod')->references('id')->on('produtos');
            $table->foreign('produto_situacao_id', 'pei_prod_sit')->references('id')->on('produto_situacoes');
        });
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Tabela: materiais_movimentacoes '''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Schema::rename('materiais_movimentacoes', 'produtos_movimentacoes');
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Tabela: materiais_movimentacoes_itens '''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // 1. Renomear a tabela mantendo os dados
        Schema::rename('materiais_movimentacoes_itens', 'produtos_movimentacoes_itens');

        // 2. Renomear colunas (mantém os dados)
        Schema::table('produtos_movimentacoes_itens', function (Blueprint $table) {
            $table->renameColumn('material_movimentacao_id', 'produto_movimentacao_id');
            $table->renameColumn('material_entrada_item_id', 'produto_entrada_item_id');
        });

        // 3. Adicionar as novas FKs (após renomear colunas)
        Schema::table('produtos_movimentacoes_itens', function (Blueprint $table) {
            $table->foreign('produto_movimentacao_id', 'pmi_prod_mov')->references('id')->on('produtos_movimentacoes');
            $table->foreign('produto_entrada_item_id', 'pmi_prod_ent_ite')->references('id')->on('produtos_entradas_itens');
        });
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Tabela: materiais_controle_situacoes_itens ''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // 1. Renomear a tabela mantendo os dados
        Schema::rename('materiais_controle_situacoes_itens', 'produtos_controle_situacoes_itens');

        // 2. Renomear colunas (mantém os dados)
        Schema::table('produtos_controle_situacoes_itens', function (Blueprint $table) {
            $table->renameColumn('material_entrada_item_id', 'produto_entrada_item_id');
            $table->renameColumn('anterior_material_situacao_id', 'anterior_produto_situacao_id');
            $table->renameColumn('atual_material_situacao_id', 'atual_produto_situacao_id');
        });

        // 3. Adicionar as novas FKs (após renomear colunas)
        Schema::table('produtos_controle_situacoes_itens', function (Blueprint $table) {
            $table->foreign('produto_entrada_item_id', 'pcsi_prod_ent_item')->references('id')->on('produtos_entradas_itens');
            $table->foreign('anterior_produto_situacao_id', 'pcsi_ant_prod_sit')->references('id')->on('produto_situacoes');
            $table->foreign('atual_produto_situacao_id', 'pcsi_atu_prod_sit')->references('id')->on('produto_situacoes');
        });
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
};
