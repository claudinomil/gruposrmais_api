<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('relatorios', function (Blueprint $table) {
            // Remover chave estrangeira e coluna
            $table->dropForeign(['agrupamento_id']);
            $table->dropColumn('agrupamento_id');
        });
    }
};