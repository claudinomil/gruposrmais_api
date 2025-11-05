<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Update2ClientesExecutivosTable extends Migration
{
    public function up()
    {
        Schema::table('clientes_executivos', function (Blueprint $table) {
            $table->dropColumn('foto');
            
            $table->string('fotografia_documento')->nullable();
            $table->string('fotografia_cartao_emergencial')->nullable();
        });
    }

    public function down()
    {
        Schema::table('clientes_executivos', function (Blueprint $table) {
            $table->string('foto')->nullable();
            
            $table->dropColumn('fotografia_documento');
            $table->dropColumn('fotografia_cartao_emergencial');
        });
    }
}
