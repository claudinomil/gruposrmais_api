<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrigadasIncendiosTable extends Migration
{
    public function up()
    {
        Schema::create('brigadas_incendios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas');
            $table->foreignId('cliente_id')->constrained('clientes');
            
            $table->integer('numero_brigada_incendio')->unique();
            $table->integer('ano_brigada_incendio');
            
            $table->date('data_abertura')->nullable(); // Data de criação da BI
            $table->time('hora_abertura')->nullable(); // Hora de criação da BI
            $table->date('data_prevista')->nullable(); // Data prevista para conclusão
            $table->time('hora_prevista')->nullable(); // Hora prevista para conclusão
            $table->date('data_conclusao')->nullable(); // Data real da conclusão
            $table->time('hora_conclusao')->nullable(); // Hora real da conclusão
            $table->date('data_finalizacao')->nullable(); // Data real da finalização
            $table->time('hora_finalizacao')->nullable(); // Hora real da finalização
            
            $table->string('cliente_nome')->nullable();
            $table->string('cliente_cnpj')->nullable();
            $table->string('cliente_email')->nullable();
            $table->string('cliente_telefone')->nullable();
            $table->string('cliente_celular')->nullable();
            $table->string('cliente_logradouro')->nullable();
            $table->string('cliente_bairro')->nullable();
            $table->string('cliente_logradouro_numero')->nullable();
            $table->string('cliente_logradouro_complemento')->nullable();
            $table->string('cliente_cidade')->nullable();
            $table->string('cliente_uf')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('brigadas_incendios');
    }
}