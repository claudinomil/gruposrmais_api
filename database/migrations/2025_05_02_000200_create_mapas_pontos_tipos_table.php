<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMapasPontosTiposTable extends Migration
{
    public function up()
    {
        Schema::create('mapas_pontos_tipos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mapas_pontos_tipos');
    }
}
