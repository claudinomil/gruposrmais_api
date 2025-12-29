<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('materiais_controle_situacoes_itens', function (Blueprint $table) {
            $table->time('hora_alteracao')->default('00:00:00');
        });
    }
};
