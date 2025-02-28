<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFornecedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas');
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
            $table->string('email')->nullable()->unique();
            $table->string('site')->nullable();
            $table->string('telefone_1')->nullable();
            $table->string('telefone_2')->nullable();
            $table->string('celular_1')->nullable();
            $table->string('celular_2')->nullable();
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
        Schema::dropIfExists('fornecedores');
    }
}
