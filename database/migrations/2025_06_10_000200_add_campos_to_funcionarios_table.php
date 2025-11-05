<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCamposToFuncionariosTable extends Migration
{
    public function up()
    {
        Schema::table('funcionarios', function (Blueprint $table) {
            $table->text('tipo_sanguineo')->nullable();
            $table->text('fator_rh')->nullable();
            $table->decimal('altura', 5, 2)->nullable();
            $table->decimal('peso', 6, 3)->nullable();
            $table->string('doenca_diabetes')->nullable();
            $table->string('doenca_hipertensao')->nullable();
            $table->string('doenca_asma')->nullable();
            $table->string('doenca_renal')->nullable();
            $table->string('doenca_cardiaca')->nullable();
            $table->string('doenca_outras')->nullable();
            $table->string('deficiencia_qual')->nullable();
            $table->string('cirurgia_quais_quando')->nullable();
            $table->string('hospitalizado_quando_porque')->nullable();
            $table->string('convulsoes_epilepsia_ultimo_episodio')->nullable();
            $table->string('alergia_medicamentos_alimentos_substancias')->nullable();
            $table->string('medicacao_continua_quais_dosagem_horarios')->nullable();
            $table->string('plano_saude_qual')->nullable();
            $table->string('fumante')->nullable();
            $table->string('bebida_alcoolica')->nullable();
            $table->string('atividade_fisica')->nullable();
            $table->string('doenca_familia_diabetes')->nullable();
            $table->string('doenca_familia_hipertensao')->nullable();
            $table->string('doenca_familia_epilepsia')->nullable();
            $table->string('doenca_familia_cardiaca')->nullable();
            $table->string('doenca_familia_cancer')->nullable();
            $table->string('doenca_familia_outras')->nullable();
            $table->string('contato_1_nome')->nullable();
            $table->string('contato_1_parentesco')->nullable();
            $table->string('contato_1_telefone')->nullable();
            $table->string('contato_1_celular')->nullable();
            $table->string('contato_2_nome')->nullable();
            $table->string('contato_2_parentesco')->nullable();
            $table->string('contato_2_telefone')->nullable();
            $table->string('contato_2_celular')->nullable();
        });
    }

    public function down()
    {
        Schema::table('funcionarios', function (Blueprint $table) {
            $table->dropColumn([
                'tipo_sanguineo',
                'fator_rh',
                'altura',
                'peso',
                'doenca_diabetes',
                'doenca_hipertensao',
                'doenca_asma',
                'doenca_renal',
                'doenca_cardiaca',
                'doenca_outras',
                'deficiencia_qual',
                'cirurgia_quais_quando',
                'hospitalizado_quando_porque',
                'convulsoes_epilepsia_ultimo_episodio',
                'alergia_medicamentos_alimentos_substancias',
                'medicacao_continua_quais_dosagem_horarios',
                'plano_saude_qual',
                'fumante',
                'bebida_alcoolica',
                'atividade_fisica',
                'doenca_familia_diabetes',
                'doenca_familia_hipertensao',
                'doenca_familia_epilepsia',
                'doenca_familia_cardiaca',
                'doenca_familia_cancer',
                'doenca_familia_outras',
                'contato_1_nome',
                'contato_1_parentesco',
                'contato_1_telefone',
                'contato_1_celular',
                'contato_2_nome',
                'contato_2_parentesco',
                'contato_2_telefone',
                'contato_2_celular'
            ]);
        });
    }
}
