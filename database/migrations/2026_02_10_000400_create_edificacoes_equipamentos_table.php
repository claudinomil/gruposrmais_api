<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mapas_preventivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('edificacao_local_id')->constrained('edificacoes_locais');
            $table->foreignId('sistema_preventivo_id')->constrained('sistemas_preventivos');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mapas_preventivos');
    }
};
