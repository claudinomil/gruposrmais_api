<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdensServicosServicosTable extends Migration
{
    public function up()
    {
        Schema::create('ordens_servicos_servicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ordem_servico_id')->constrained('ordens_servicos');
            $table->foreignId('servico_id')->constrained('servicos');
            $table->string('servico_nome');
            $table->foreignId('responsavel_funcionario_id')->nullable()->constrained('funcionarios');
            $table->string('responsavel_funcionario_nome')->nullable();
            $table->integer('servico_item');
            $table->decimal('servico_valor')->nullable();
            $table->integer('servico_quantidade')->nullable();
            $table->decimal('servico_valor_total', 20, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ordens_servicos_servicos');
    }
}
