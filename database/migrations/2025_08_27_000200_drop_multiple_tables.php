<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class DropMultipleTables extends Migration
{
    public function up()
    {
        Schema::dropIfExists('brigadas_rondas_seguranca_medidas');
        Schema::dropIfExists('brigadas_rondas');
        Schema::dropIfExists('brigadas_escalas');
        Schema::dropIfExists('brigadas');

        Schema::dropIfExists('clientes_segurancas_medidas');
        Schema::dropIfExists('cliente_servicos_brigadistas');
        Schema::dropIfExists('clientes_servicos');
    }

    public function down()
    {}
}
