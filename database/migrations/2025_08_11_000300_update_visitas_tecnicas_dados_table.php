<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateVisitasTecnicasDadosTable extends Migration
{
    public function up()
    {
        Schema::table('visitas_tecnicas_dados', function (Blueprint $table) {
            $table->integer('quantidade')->default(0);

            $table->text('pdf_1')->nullable();
            $table->text('pdf_2')->nullable();
            $table->text('pdf_3')->nullable();

            $table->integer('completa')->default(0);
            $table->integer('completa_ordem')->default(0);

            $table->integer('sintetica')->default(0);
            $table->integer('sintetica_ordem')->default(0);

            $table->dropColumn('ordem');
            $table->dropColumn('respostas');

            $table->integer('opcoes')->default(0);
        });
    }

    public function down()
    {
        Schema::table('visitas_tecnicas_dados', function (Blueprint $table) {
            $table->dropColumn('quantidade');

            $table->dropColumn('pdf_1');
            $table->dropColumn('pdf_2');
            $table->dropColumn('pdf_3');

            $table->dropColumn('completa');
            $table->dropColumn('completa_ordem');

            $table->dropColumn('sintetica');
            $table->dropColumn('sintetica_ordem');

            $table->integer('ordem');
            $table->text('respostas');

            $table->dropColumn('opcoes');
        });
    }
}
