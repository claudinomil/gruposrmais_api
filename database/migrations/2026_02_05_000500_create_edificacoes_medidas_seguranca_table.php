<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('edificacoes_medidas_seguranca', function (Blueprint $table) {
            $table->id();
            $table->foreignId('edificacao_nivel_id')->constrained('edificacoes_niveis');
            $table->foreignId('medida_seguranca_id')->constrained('medidas_seguranca');
            $table->integer('quantidade')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('edificacoes_medidas_seguranca');
    }
};
