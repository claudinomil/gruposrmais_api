<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Update2ClientesTable extends Migration
{
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropForeign(['empresa_id']);
            $table->dropColumn('empresa_id');

            $table->foreignId('rede_cliente_id')->nullable()->constrained('clientes');
        });
    }

    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->foreignId('empresa_id')->constrained('empresas');

            $table->dropColumn('rede_cliente_id');
        });
    }
}
