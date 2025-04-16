<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVeiculoModelosTable extends Migration
{
    public function up()
    {
        Schema::create('veiculo_modelos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('veiculo_marca_id')->constrained('veiculo_marcas');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('veiculo_modelos');
    }
}
