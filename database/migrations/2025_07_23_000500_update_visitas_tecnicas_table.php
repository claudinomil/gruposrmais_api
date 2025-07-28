<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateVisitasTecnicasTable extends Migration
{
    public function up()
    {
        Schema::table('visitas_tecnicas', function (Blueprint $table) {
            $table->foreignId('empresa_id')->constrained('empresas');
        });
    }

    public function down()
    {
        Schema::table('visitas_tecnicas', function (Blueprint $table) {
            $table->dropForeign(['empresa_id']);
            $table->dropColumn('empresa_id');
        });
    }
}
