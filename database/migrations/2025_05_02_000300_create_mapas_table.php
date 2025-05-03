<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMapasTable extends Migration
{
    public function up()
    {
        Schema::create('mapas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mapa_ponto_tipo_id')->constrained('mapas_pontos_tipos');
            $table->string('name');
            $table->string('descricao')->nullable();
            $table->string('latitude');
            $table->string('longitude');
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->string('icone');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mapas');
    }
}
