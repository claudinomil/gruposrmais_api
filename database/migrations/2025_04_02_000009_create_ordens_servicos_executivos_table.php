<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdensServicosExecutivosTable extends Migration
{
    public function up()
    {
        Schema::create('ordens_servicos_executivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ordem_servico_id')->constrained('ordens_servicos');
            $table->foreignId('cliente_executivo_id')->constrained('clientes_executivos');
            $table->string('cliente_executivo_item');
            $table->string('cliente_executivo_nome');
            $table->string('cliente_executivo_funcao');
            $table->foreignId('cliente_executivo_veiculo_id')->constrained('veiculos');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ordens_servicos_executivos');
    }
}
