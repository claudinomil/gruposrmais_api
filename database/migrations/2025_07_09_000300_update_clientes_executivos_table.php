<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateClientesExecutivosTable extends Migration
{
    public function up()
    {
        Schema::table('clientes_executivos', function (Blueprint $table) {
            $table->string('nome_profissional')->nullable();
        });
    }

    public function down()
    {
        Schema::table('clientes_executivos', function (Blueprint $table) {
            $table->dropColumn('nome_profissional');
        });
    }
}
