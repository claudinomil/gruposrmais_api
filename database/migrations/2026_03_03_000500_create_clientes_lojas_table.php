<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('clientes_lojas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('edificacao_nivel_id')->constrained('edificacoes_niveis');
            $table->foreignId('subordinado_cliente_id')->nullable()->constrained('clientes');
            $table->string('luc', 30);
            $table->integer('ordem');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clientes_lojas');
    }
};
