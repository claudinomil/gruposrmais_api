<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Update2VisitasTecnicasTable extends Migration
{
    public function up()
    {
        Schema::table('visitas_tecnicas', function (Blueprint $table) {
            $table->integer('vt_cs');
            $table->string('cliente_cnpj', 20)->nullable();
            $table->string('cliente_logradouro_numero', 10)->nullable();
            $table->string('cliente_logradouro_complemento', 30)->nullable();
            $table->string('cliente_uf', 10)->nullable();

            //Informações do Funcionário Responsável pela Visita Técnica
            $table->foreignId('responsavel_funcionario_id')->nullable()->constrained('funcionarios');
            $table->string('responsavel_funcionario_nome', 100)->nullable();
            $table->string('responsavel_funcionario_email', 100)->nullable();

            //Informações de Finalização da Visita Técnica
            $table->text('nivel')->nullable();
            $table->text('classificacao')->nullable();
            $table->text('comentarios')->nullable();
        });
    }

    public function down()
    {
        Schema::table('visitas_tecnicas', function (Blueprint $table) {
            $table->dropColumn('cs');
            $table->dropColumn('cliente_cnpj');
            $table->dropColumn('cliente_logradouro_numero');
            $table->dropColumn('cliente_logradouro_complemento');
            $table->dropColumn('cliente_uf');

            $table->dropForeign(['responsavel_funcionario_id']);
            $table->dropColumn('responsavel_funcionario_id');

            $table->dropColumn('responsavel_funcionario_nome');
            $table->dropColumn('responsavel_funcionario_email');

            //Informações de Finalização da Visita Técnica
            $table->dropColumn('nivel');
            $table->dropColumn('classificacao');
            $table->dropColumn('comentarios');
        });
    }
}
