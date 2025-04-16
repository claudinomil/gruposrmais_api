<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropostasTable extends Migration
{
    public function up()
    {
        Schema::create('propostas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas');
            $table->date('data_proposta')->nullable();
            $table->string('data_proposta_extenso')->nullable();
            $table->integer('numero_proposta')->nullable();
            $table->integer('ano_proposta')->nullable();

            //INFORMAÇÕES CLIENTE
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->string('cliente_nome')->nullable();
            $table->string('cliente_logradouro')->nullable();
            $table->string('cliente_bairro')->nullable();
            $table->string('cliente_cidade')->nullable();

            //AOS CUIDADOS
            $table->string('aos_cuidados')->nullable();

            //TEXTO ACIMA DA TABELA DE SERVIÇOS
            $table->text('texto_acima_tabela_servico')->nullable();

            //1. DO VALOR DESCONTO
            $table->decimal('porcentagem_desconto', 20, 2)->nullable();
            $table->decimal('valor_desconto', 20, 2)->nullable();
            $table->string('valor_desconto_extenso')->nullable();

            //2. DO VALOR TOTAL (vai ser preenchido pela soma dos serviços)
            $table->decimal('valor_total', 20, 2)->nullable();
            $table->string('valor_total_extenso')->nullable();

            //3. DA FORMA E CONDIÇÕES DE PAGAMENTO
            $table->string('forma_pagamento')->nullable();

            //4. DAS GENERALIDADES
            $table->text('paragrafo_1')->nullable();
            $table->text('paragrafo_2')->nullable();
            $table->text('paragrafo_3')->nullable();
            $table->text('paragrafo_4')->nullable();
            $table->text('paragrafo_5')->nullable();
            $table->text('paragrafo_6')->nullable();
            $table->text('paragrafo_7')->nullable();
            $table->text('paragrafo_8')->nullable();
            $table->text('paragrafo_9')->nullable();
            $table->text('paragrafo_10')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('propostas');
    }
}
