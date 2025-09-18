<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMateriaisTable extends Migration
{
    public function up()
    {
        Schema::create('materiais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_categoria_id')->constrained('material_categorias');
            $table->string('name');
            $table->string('descricao')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('materiais');
    }
}