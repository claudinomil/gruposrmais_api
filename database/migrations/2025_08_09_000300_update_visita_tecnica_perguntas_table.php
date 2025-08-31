<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateVisitaTecnicaPerguntasTable extends Migration
{
    public function up()
    {
        Schema::table('visita_tecnica_perguntas', function (Blueprint $table) {
            $table->integer('completa')->default(0);
            $table->integer('completa_ordem')->default(0);

            $table->integer('sintetica')->default(0);
            $table->integer('sintetica_ordem')->default(0);

            $table->dropColumn('respostas');

            $table->integer('opcoes')->default(0);
        });
    }

    public function down()
    {
        Schema::table('visita_tecnica_perguntas', function (Blueprint $table) {
            $table->dropColumn('completa');
            $table->dropColumn('completa_ordem');

            $table->dropColumn('sintetica');
            $table->dropColumn('sintetica_ordem');

            $table->text('respostas');

            $table->dropColumn('opcoes');
        });
    }
}
