<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('edificacoes_niveis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('edificacao_id')->constrained('edificacoes');
            $table->integer('ordem')->default(0);
            $table->integer('nivel')->default(0);
            $table->string('name')->nullable();
            $table->decimal('area_construida')->default(0.00);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('edificacoes_niveis');
    }
};
