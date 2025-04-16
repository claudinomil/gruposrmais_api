<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdensServicosVeiculosTable extends Migration
{
    public function up()
    {
        Schema::create('ordens_servicos_veiculos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ordem_servico_id')->constrained('ordens_servicos');
            $table->foreignId('veiculo_id')->constrained('veiculos');
            $table->integer('veiculo_item');
            $table->string('veiculo_marca');
            $table->string('veiculo_modelo');
            $table->string('veiculo_placa');
            $table->string('veiculo_combustivel');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ordens_servicos_veiculos');
    }
}
