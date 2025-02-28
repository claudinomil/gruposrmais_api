<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitasTecnicasTable extends Migration
{
    public function up()
    {
        Schema::create('visitas_tecnicas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas');
            $table->foreignId('cliente_servico_id')->unique()->constrained('clientes_servicos');

            /*
             * Dados da Edificação
             */
            $table->integer('numero_pavimentos')->nullable();
            $table->decimal('altura')->nullable();
            $table->decimal('area_total_construida')->nullable();
            $table->integer('lotacao')->nullable();
            $table->integer('carga_incendio')->nullable();
            $table->string('incendio_risco')->nullable();
            $table->string('grupo')->nullable();
            $table->string('ocupacao_uso')->nullable();
            $table->string('divisao')->nullable();
            $table->string('descricao')->nullable();
            $table->text('definicao')->nullable();

            /*
             * Documentação Exigida
             */
            $table->integer('projeto_scip')->nullable();
            $table->string('projeto_scip_numero')->nullable();
            $table->integer('laudo_exigencias')->nullable();
            $table->string('laudo_exigencias_numero')->nullable();
            $table->date('laudo_exigencias_data_emissao')->nullable();
            $table->date('laudo_exigencias_data_vencimento')->nullable();
            $table->integer('certificado_aprovacao')->nullable();
            $table->string('certificado_aprovacao_numero')->nullable();
            $table->integer('certificado_aprovacao_simplificado')->nullable();
            $table->string('certificado_aprovacao_simplificado_numero')->nullable();
            $table->integer('certificado_aprovacao_assistido')->nullable();
            $table->string('certificado_aprovacao_assistido_numero')->nullable();

            /*
             * Dados Executou o Serviço
             */
            $table->date('executado_data')->nullable();
            $table->foreignId('executado_user_id')->nullable()->constrained('users');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('visitas_tecnicas');
    }
}
