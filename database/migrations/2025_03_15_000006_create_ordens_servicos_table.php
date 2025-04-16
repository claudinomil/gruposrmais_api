<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdensServicosTable extends Migration
{
    public function up()
    {
        Schema::create('ordens_servicos', function (Blueprint $table) {
            //Informações Gerais
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas');
            $table->integer('numero_ordem_servico')->unique();
            $table->integer('ano_ordem_servico');
            $table->foreignId('ordem_servico_tipo_id')->constrained('ordem_servico_tipos');
            $table->foreignId('ordem_servico_status_id')->constrained('ordem_servico_status');
            $table->date('data_abertura')->nullable(); //Data de criação da OS
            $table->time('hora_abertura')->nullable(); //Hora de criação da OS
            $table->date('data_prevista')->nullable(); //Data prevista para conclusão
            $table->time('hora_prevista')->nullable(); //Hora prevista para conclusão
            $table->date('data_conclusao')->nullable(); //Data real da conclusão
            $table->time('hora_conclusao')->nullable(); //Hora real da conclusão
            $table->date('data_finalizacao')->nullable(); //Data real da finalização
            $table->time('hora_finalizacao')->nullable(); //Hora real da finalização

            //Informações do Cliente
            $table->foreignId('cliente_id')->nullable()->constrained('clientes');
            $table->string('cliente_nome')->nullable();
            $table->string('cliente_telefone')->nullable();
            $table->string('cliente_celular')->nullable();
            $table->string('cliente_email')->nullable();
            $table->string('cliente_logradouro')->nullable();
            $table->string('cliente_bairro')->nullable();
            $table->string('cliente_cidade')->nullable();

            //Informações do Serviço
            $table->text('descricao_servico')->nullable();
            $table->foreignId('ordem_servico_prioridade_id')->constrained('ordem_servico_prioridades');
            $table->text('observacao')->nullable();

            //Valor Total
            $table->decimal('valor_total', 20, 2)->nullable();
            $table->string('valor_total_extenso')->nullable();

            //Desconto
            $table->decimal('porcentagem_desconto', 20, 2)->nullable();
            $table->decimal('valor_desconto', 20, 2)->nullable();
            $table->string('valor_desconto_extenso')->nullable();

            //Pagamento
            $table->foreignId('forma_pagamento_id')->nullable()->constrained('formas_pagamentos');
            $table->integer('forma_pagamento_status_id')->nullable();
            $table->text('forma_pagamento_observacao')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ordens_servicos');
    }
}
