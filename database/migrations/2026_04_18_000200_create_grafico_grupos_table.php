<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('grafico_grupos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('ordem_visualizacao')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('grafico_grupos');
    }
};
