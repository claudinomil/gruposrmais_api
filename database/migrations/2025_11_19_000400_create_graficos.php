<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('graficos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('dashboard');
            $table->integer('tipo'); // 1(Gráfico de Pizza)  2(Gráfico de Bar)
            $table->integer('ordem_visualizacao');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('graficos');
    }
};
