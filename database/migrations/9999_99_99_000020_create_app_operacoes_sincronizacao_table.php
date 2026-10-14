<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('app_operacoes_sincronizacao', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_operacao');
            $table->string('tabela');
            $table->unsignedBigInteger('registro_id')->nullable();
            $table->string('operacao');
            $table->unsignedSmallInteger('status_http')->nullable();
            $table->json('resposta')->nullable();
            $table->timestamps();
            $table->unique('id_operacao');
        });
    }

    public function down()
    {
        Schema::dropIfExists('app_operacoes_sincronizacao');
    }
};
