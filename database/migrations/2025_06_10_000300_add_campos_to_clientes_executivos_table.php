<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCamposToClientesExecutivosTable extends Migration
{
    public function up()
    {
        Schema::table('clientes_executivos', function (Blueprint $table) {
            $table->date('data_nascimento')->nullable();
            $table->foreignId('genero_id')->nullable()->constrained('generos');
            $table->foreignId('nacionalidade_id')->nullable()->constrained('nacionalidades');
            $table->string('email')->nullable();
            $table->string('telefone_1')->nullable();
            $table->string('telefone_2')->nullable();
            $table->string('celular_1')->nullable();
            $table->string('celular_2')->nullable();
            $table->text('foto')->nullable();
            $table->string('cpf')->nullable();
            $table->foreignId('personal_identidade_estado_id')->nullable()->constrained('estados');
            $table->foreignId('personal_identidade_orgao_id')->nullable()->constrained('identidade_orgaos');
            $table->string('personal_identidade_numero')->nullable();
            $table->text('cep')->nullable();
            $table->text('numero')->nullable();
            $table->text('complemento')->nullable();
            $table->text('logradouro')->nullable();
            $table->text('bairro')->nullable();
            $table->text('localidade')->nullable();
            $table->text('uf')->nullable();
            $table->text('tipo_sanguineo')->nullable();
            $table->text('fator_rh')->nullable();
            $table->decimal('altura', 5, 2)->nullable();
            $table->decimal('peso', 5, 2)->nullable();
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
        Schema::table('clientes_executivos', function (Blueprint $table) {
            $table->dropColumn([
                'genero_id',
                'data_nascimento',
                'nacionalidade_id',
                'cpf',
                'personal_identidade_estado_id',
                'personal_identidade_orgao_id',
                'personal_identidade_numero',
                'email',
                'telefone_1',
                'telefone_2',
                'celular_1',
                'celular_2',
                'foto',
                'cep',
                'numero',
                'complemento',
                'logradouro',
                'bairro',
                'localidade',
                'uf',
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
