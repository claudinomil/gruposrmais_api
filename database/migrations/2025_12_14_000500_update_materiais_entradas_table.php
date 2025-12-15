<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('materiais_entradas', function (Blueprint $table) {
            $table->foreignId('estoque_local_id')->nullable()->constrained('estoques_locais');
        });
    }
};
