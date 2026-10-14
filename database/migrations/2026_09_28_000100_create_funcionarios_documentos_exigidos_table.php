<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('funcionarios_documentos_exigidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('funcionario_id')->constrained('funcionarios');
            $table->foreignId('documento_id')->constrained('documentos');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('funcionarios_documentos_exigidos');
    }
};