<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelatoriosExaustoesTable extends Migration
{
    public function up()
    {
        Schema::create('relatorios_exaustoes', function (Blueprint $table) {
            $table->id();
            $table->integer('numero_relatorio_exaustao')->unique();
            $table->integer('ano_relatorio_exaustao');
            $table->foreignId('relatorio_exaustao_status_id')->constrained('relatorio_exaustao_status');
            $table->date('data_abertura')->nullable(); //Data de criação da OS
            $table->time('hora_abertura')->nullable(); //Hora de criação da OS
            $table->date('data_prevista')->nullable(); //Data prevista para conclusão
            $table->time('hora_prevista')->nullable(); //Hora prevista para conclusão
            $table->date('data_conclusao')->nullable(); //Data real da conclusão
            $table->time('hora_conclusao')->nullable(); //Hora real da conclusão
            $table->date('data_finalizacao')->nullable(); //Data real da finalização
            $table->time('hora_finalizacao')->nullable(); //Hora real da finalização

            //Informações do Cliente onde vai ser executada a vistoria
            $table->foreignId('cliente_id')->nullable()->constrained('clientes');
            $table->string('cliente_nome')->nullable();
            $table->string('cliente_telefone')->nullable();
            $table->string('cliente_celular')->nullable();
            $table->string('cliente_email')->nullable();
            $table->string('cliente_logradouro')->nullable();
            $table->string('cliente_bairro')->nullable();
            $table->string('cliente_cidade')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('relatorios_exaustoes');
    }
}
