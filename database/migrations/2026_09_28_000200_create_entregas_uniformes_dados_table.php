<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('entregas_uniformes_dados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entrega_uniforme_id')->constrained('entregas_uniformes')->index('feud_entrega_uniforme_id');
            $table->foreignId('funcionario_id')->constrained('funcionarios');
            $table->string('funcionario_nome')->nullable();
            $table->foreignId('uniforme_id')->constrained('uniformes');
            $table->string('uniforme_nome')->nullable();
            $table->integer('quantidade');
            $table->string('tamanho', 10);
            $table->date('data_entrega')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('entregas_uniformes_dados');
    }
};
