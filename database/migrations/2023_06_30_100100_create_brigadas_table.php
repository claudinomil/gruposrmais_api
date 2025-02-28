<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrigadasTable extends Migration
{
    public function up()
    {
        Schema::create('brigadas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas');
            $table->foreignId('cliente_servico_id')->unique()->constrained('clientes_servicos');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('brigadas');
    }
}
