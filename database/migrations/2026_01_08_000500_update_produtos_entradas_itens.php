<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('produtos_entradas_itens', function (Blueprint $table) {
            $table->foreignId('produto_tipo_id')->nullable(1)->constrained('produto_tipos');
            $table->string('produto_tipo_name')->nullable();
        });
    }
};
