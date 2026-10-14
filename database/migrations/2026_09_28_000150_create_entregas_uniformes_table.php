<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('entregas_uniformes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tomador_servico_cliente_id')->nullable()->constrained('clientes')->index('feu_tomador_servico_cliente_id');
            $table->string('tomador_servico_cliente_nome')->nullable();
            $table->foreignId('funcao_id')->nullable()->constrained('funcoes');
            $table->string('funcao_nome')->nullable();
            $table->string('numero_entrega', 10);
            $table->date('data_entrega')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('entregas_uniformes');
    }
};
