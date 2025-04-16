<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVeiculosTable extends Migration
{
    public function up()
    {
        Schema::create('veiculos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas');
            $table->foreignId('veiculo_marca_id')->constrained('veiculo_marcas');
            $table->foreignId('veiculo_modelo_id')->constrained('veiculo_modelos');
            $table->string('placa')->unique();
            $table->string('renavam')->unique()->nullable();
            $table->string('chassi')->unique()->nullable();
            $table->integer('ano_modelo')->nullable();
            $table->integer('ano_fabricacao')->nullable();
            $table->string('cor')->nullable();
            $table->foreignId('veiculo_combustivel_id')->constrained('veiculo_combustiveis');

            //GNV
            //1(Sim)
            //2(Não)
            $table->integer('gnv')->nullable();

            //Blindado
            //1(Sim)
            //2(Não)
            $table->integer('blindado')->nullable();
            $table->foreignId('veiculo_categoria_id')->constrained('veiculo_categorias');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ordens_servicos');
    }
}
