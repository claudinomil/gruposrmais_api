<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Update2FuncionariosTable extends Migration
{
    public function up()
    {
        Schema::table('funcionarios', function (Blueprint $table) {
            $table->foreignId('motivo_demissao_id')->nullable()->constrained('motivos_demissoes');
            $table->foreignId('motivo_afastamento_id')->nullable()->constrained('motivos_afastamentos');

            $table->foreignId('carteira_nacional_estado_id')->nullable()->constrained('estados');
            $table->foreignId('carteira_nacional_orgao_id')->nullable()->constrained('identidade_orgaos');
            $table->string('carteira_nacional_numero')->nullable();
            $table->date('carteira_nacional_data_emissao')->nullable();

            $table->string('titulo_eleitor_numero')->nullable();
            $table->string('titulo_eleitor_zona')->nullable();
            $table->string('titulo_eleitor_secao')->nullable();

            $table->foreignId('atestado_saude_ocupacional_tipo_id')->nullable()->constrained('atestado_saude_ocupacional_tipos');
            $table->date('atestado_saude_ocupacional_data_emissao')->nullable();

            $table->string('empresa_id')->nullable()->constrained('empresas');

            $table->text('fotografia_documento')->nullable();
            $table->text('fotografia_cartao_emergencial')->nullable();
        });
    }

    public function down()
    {
        Schema::table('funcionarios', function (Blueprint $table) {
            $table->dropForeign(['motivo_demissao_id']);
            $table->dropColumn('motivo_demissao_id');

            $table->dropForeign(['motivo_afastamento_id']);
            $table->dropColumn('motivo_afastamento_id');

            $table->dropForeign(['carteira_nacional_estado_id']);
            $table->dropColumn('carteira_nacional_estado_id');

            $table->dropForeign(['carteira_nacional_orgao_id']);
            $table->dropColumn('carteira_nacional_orgao_id');

            $table->dropColumn('titulo_eleitor_numero');
            $table->dropColumn('titulo_eleitor_zona');
            $table->dropColumn('titulo_eleitor_secao');

            $table->dropForeign(['atestado_saude_ocupacional_tipo_id']);
            $table->dropColumn('atestado_saude_ocupacional_tipo_id');

            $table->dropColumn('atestado_saude_ocupacional_data_emissao');

            $table->dropColumn('empresa_id');

            $table->dropColumn('fotografia_documento');
            $table->dropColumn('fotografia_cartao_emergencial');
        });
    }
}
