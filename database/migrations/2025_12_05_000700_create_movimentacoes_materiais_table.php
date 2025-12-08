<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovimentacoesMateriaisTable extends Migration
{
    public function up()
    {
        Schema::create('movimentacoes_materiais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained('materiais');
            $table->unsignedBigInteger('origem_cliente_id')->nullable();
            $table->unsignedBigInteger('origem_local_id')->nullable();
            $table->unsignedBigInteger('destino_cliente_id')->nullable();
            $table->unsignedBigInteger('destino_local_id')->nullable();
            $table->enum('tipo', ['entrada', 'saida', 'transferencia']);
            $table->decimal('quantidade', 12, 2);
            $table->dateTime('data_movimentacao');
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('movimentacoes_materiais');
    }
}
