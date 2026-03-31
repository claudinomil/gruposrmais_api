<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sistemas_preventivos_equipamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sistema_preventivo_id')->constrained('sistemas_preventivos')->name('spe_sistema_preventivo_id');
            $table->foreignId('equipamento_preventivo_id')->constrained('equipamentos_preventivos')->name('spe_equipamento_preventivo_id');
            $table->integer('equipamento_preventivo_item');
            $table->string('equipamento_preventivo_nome');
            $table->integer('equipamento_preventivo_quantidade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sistemas_preventivos_equipamentos');
    }
};
