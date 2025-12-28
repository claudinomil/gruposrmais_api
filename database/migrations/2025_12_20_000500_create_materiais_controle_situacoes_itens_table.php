<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('materiais_controle_situacoes_itens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_entrada_item_id')->constrained('materiais_entradas_itens')->name('mcsi_mat_ent_item');
            $table->foreignId('anterior_material_situacao_id')->constrained('materiais_situacoes')->name('mcsi_ant_mat_sit');
            $table->foreignId('atual_material_situacao_id')->constrained('materiais_situacoes')->name('mcsi_atu_mat_sit');
            $table->foreignId('anterior_estoque_local_id')->nullable()->constrained('estoques_locais')->name('mcsi_ant_est_loc');
            $table->foreignId('atual_estoque_local_id')->nullable()->constrained('estoques_locais')->name('mcsi_atu_est_loc');
            $table->text('observacao')->nullable();
            $table->date('data_alteracao');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('materiais_controle_situacoes_itens');
    }
};
