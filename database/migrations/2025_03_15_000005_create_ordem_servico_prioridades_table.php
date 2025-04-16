<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdemServicoPrioridadesTable extends Migration
{
    public function up()
    {
        Schema::create('ordem_servico_prioridades', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ordem_servico_prioridades');
    }
}
