<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateServicosTable extends Migration
{
    public function up()
    {
        Schema::table('servicos', function (Blueprint $table) {
            $table->dropForeign(['empresa_id']);
            $table->dropColumn('empresa_id');
        });
    }

    public function down()
    {
        Schema::table('servicos', function (Blueprint $table) {
            $table->foreignId('empresa_id')->constrained('empresas');
        });
    }
}
