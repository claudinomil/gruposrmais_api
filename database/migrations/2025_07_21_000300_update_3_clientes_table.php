<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Update3ClientesTable extends Migration
{
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->string('logotipo_principal')->nullable();
            $table->string('logotipo_relatorios')->nullable();
            $table->string('logotipo_cartao_emergencial')->nullable();
        });
    }

    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn('logotipo_principal');
            $table->dropColumn('logotipo_relatorios');
            $table->dropColumn('logotipo_cartao_emergencial');
        });
    }
}
