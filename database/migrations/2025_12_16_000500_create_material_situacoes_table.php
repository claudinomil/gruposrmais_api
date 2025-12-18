<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('material_situacoes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('descricao');
            $table->integer('permite_movimentacao');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('material_situacoes');
    }
};
