<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMapasXTable extends Migration
{
    public function up()
    {
        Schema::create('mapas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modelo_id')->constrained('mapas_modelos');
            $table->foreignId('usuario_id')->constrained('users');
            $table->integer('publico');
            $table->string('name');
            $table->string('descricao')->nullable();
            $table->date('data');
            $table->time('hora');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mapas');
    }
}
