<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas');
            $table->foreignId('principal_cliente_id')->nullable()->constrained('clientes');
            $table->string('status', 1)->default(0);
            $table->string('tipo', 1)->default(0);
            $table->string('name');
            $table->string('nome_fantasia')->nullable();
            $table->string('inscricao_estadual')->nullable();
            $table->string('inscricao_municipal')->nullable();
            $table->string('cpf')->nullable();
            $table->string('cnpj')->nullable();
            $table->foreignId('identidade_estado_id')->nullable()->constrained('estados');
            $table->foreignId('identidade_orgao_id')->nullable()->constrained('identidade_orgaos');
            $table->string('identidade_numero')->nullable();
            $table->date('identidade_data_emissao')->nullable();
            $table->foreignId('genero_id')->nullable()->constrained('generos');
            $table->date('data_nascimento')->nullable();
            $table->string('cep')->nullable();
            $table->string('numero')->nullable();
            $table->string('complemento')->nullable();
            $table->string('logradouro')->nullable();
            $table->string('bairro')->nullable();
            $table->string('localidade')->nullable();
            $table->string('uf')->nullable();
            $table->string('cep_cobranca')->nullable();
            $table->string('numero_cobranca')->nullable();
            $table->string('complemento_cobranca')->nullable();
            $table->string('logradouro_cobranca')->nullable();
            $table->string('bairro_cobranca')->nullable();
            $table->string('localidade_cobranca')->nullable();
            $table->string('uf_cobranca')->nullable();
            $table->foreignId('banco_id')->nullable()->constrained('bancos');
            $table->string('agencia')->nullable();
            $table->string('conta')->nullable();
            $table->string('email')->nullable();
            $table->string('site')->nullable();
            $table->string('telefone_1')->nullable();
            $table->string('telefone_2')->nullable();
            $table->string('celular_1')->nullable();
            $table->string('celular_2')->nullable();

            $table->integer('numero_pavimentos')->nullable();
            $table->decimal('altura')->nullable();
            $table->decimal('area_total_construida')->nullable();
            $table->integer('lotacao')->nullable();
            $table->integer('carga_incendio')->nullable();
            $table->foreignId('incendio_risco_id')->nullable()->constrained('incendio_riscos');
            $table->foreignId('edificacao_classificacao_id')->nullable()->constrained('edificacao_classificacoes');

            $table->integer('projeto_scip')->nullable();
            $table->integer('laudo_exigencias')->nullable();
            $table->integer('certificado_aprovacao')->nullable();
            $table->integer('certificado_aprovacao_simplificado')->nullable();
            $table->integer('certificado_aprovacao_assistido')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
