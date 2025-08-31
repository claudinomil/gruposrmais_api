<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtestadoSaudeOcupacionalTiposTable extends Migration
{
    public function up()
    {
        Schema::create('atestado_saude_ocupacional_tipos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('atestado_saude_ocupacional_tipos');
    }
}
