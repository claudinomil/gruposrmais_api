<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('materiais_entradas_itens', function (Blueprint $table) {

            // Valor default para as Entradas: 10 - EM AQUISIÇÃO - Material em processo de compra ou aguardando entrada no estoque patrimonial
            $table->foreignId('material_situacao_id')->default(10)->constrained('material_situacoes');
        });
    }
};
