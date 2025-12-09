<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('materiais_entradas_itens', function (Blueprint $table) {
            $table->dropColumn('material_quantidade');
            $table->string('material_numero_patrimonio', 10)->nullable()->unique();
        });
    }
};
