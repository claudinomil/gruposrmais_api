<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrigadasRondasSegurancaMedidasTable extends Migration
{
    public function up()
    {
        Schema::create('brigadas_rondas_seguranca_medidas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('brigada_ronda_id')->constrained('brigadas_rondas');

            $table->integer('pavimento');
            $table->foreignId('seguranca_medida_id')->constrained('seguranca_medidas');
            $table->string('seguranca_medida_nome');
            $table->integer('seguranca_medida_quantidade')->nullable();
            $table->string('seguranca_medida_tipo')->nullable();
            $table->text('seguranca_medida_observacao')->nullable();

            $table->integer('status')->nullable()->default(0);
            $table->text('observacao')->nullable();
            $table->longText('foto')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('brigadas_rondas_seguranca_medidas');
    }
}
