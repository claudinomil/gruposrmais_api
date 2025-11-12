<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePontosInteresseEspecialidadesTable extends Migration
{
    public function up()
    {
        Schema::create('pontos_interesse_especialidades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ponto_interesse_id')->constrained('pontos_interesse');
            $table->foreignId('especialidade_id')->constrained('especialidades');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pontos_interesse_especialidades');
    }
}