<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('edificacoes_locais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('edificacao_nivel_id')->constrained('edificacoes_niveis');
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('edificacoes_locais');
    }
};
