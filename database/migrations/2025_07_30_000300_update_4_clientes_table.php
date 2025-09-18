<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Update4ClientesTable extends Migration
{
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->string('contato_1_nome')->nullable();
            $table->string('contato_1_setor')->nullable();
            $table->string('contato_1_cargo')->nullable();
            $table->string('contato_1_email')->nullable();
            $table->string('contato_2_nome')->nullable();
            $table->string('contato_2_setor')->nullable();
            $table->string('contato_2_cargo')->nullable();
            $table->string('contato_2_email')->nullable();
        });
    }

    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn('contato_1_nome');
            $table->dropColumn('contato_1_setor');
            $table->dropColumn('contato_1_cargo');
            $table->dropColumn('contato_1_email');
        });
    }
}
