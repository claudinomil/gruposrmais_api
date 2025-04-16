<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdensServicosDestinosTable extends Migration
{
    public function up()
    {
        Schema::create('ordens_servicos_destinos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ordem_servico_id')->constrained('ordens_servicos');
            $table->string('destino_ordem');
            $table->string('destino_cep');
            $table->string('destino_logradouro');
            $table->string('destino_bairro');
            $table->string('destino_localidade');
            $table->string('destino_uf');
            $table->string('destino_numero')->nullable();
            $table->string('destino_complemento')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ordens_servicos_destinos');
    }
}
