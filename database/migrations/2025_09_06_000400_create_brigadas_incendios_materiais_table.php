<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrigadasIncendiosMateriaisTable extends Migration
{
    public function up()
    {
        Schema::create('brigadas_incendios_materiais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brigada_incendio_id')->constrained('brigadas_incendios');
            $table->foreignId('material_id')->constrained('materiais');
            $table->string('material_categoria_name');
            $table->string('material_name');
            $table->integer('material_quantidade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('brigadas_incendios_materiais');
    }
}