<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropostasServicosTable extends Migration
{
    public function up()
    {
        Schema::create('propostas_servicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposta_id')->constrained('propostas');
            $table->foreignId('servico_id')->constrained('servicos');
            $table->integer('servico_item');
            $table->string('servico_nome');
            $table->decimal('servico_valor');
            $table->integer('servico_quantidade');
            $table->decimal('servico_valor_total', 20, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('propostas_servicos');
    }
}
