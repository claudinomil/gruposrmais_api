<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('grupo_id')->nullable()->constrained('grupos');
            $table->foreignId('situacao_id')->nullable()->constrained('situacoes');
            $table->string('layout_mode')->nullable();
            $table->string('layout_style')->nullable();
        });
    }

    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn('grupo_id');
            $table->dropColumn('situacao_id');
            $table->dropColumn('layout_mode');
            $table->dropColumn('layout_style');
        });
    }
}
