<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vistorias_sistemas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas');
            $table->integer('numero_vistoria_sistema')->unique();
            $table->integer('ano_vistoria_sistema');
            $table->foreignId('vistoria_sistema_status_id')->constrained('vistoria_sistema_status');

            // Datas e Horas
            $table->date('data_abertura')->nullable(); // Data de criação
            $table->time('hora_abertura')->nullable(); // Hora de criação
            $table->date('data_prevista')->nullable(); // Data prevista para conclusão
            $table->time('hora_prevista')->nullable(); // Hora prevista para conclusão
            $table->date('data_conclusao')->nullable(); // Data real da conclusão
            $table->time('hora_conclusao')->nullable(); // Hora real da conclusão
            $table->date('data_finalizacao')->nullable(); // Data real da finalização
            $table->time('hora_finalizacao')->nullable(); // Hora real da finalização

            // Cliente
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->string('cliente_nome', 100)->nullable();
            $table->string('cliente_telefone', 15)->nullable();
            $table->string('cliente_celular', 15)->nullable();
            $table->string('cliente_email', 100)->nullable();
            $table->string('cliente_logradouro', 150)->nullable();
            $table->string('cliente_bairro', 100)->nullable();
            $table->string('cliente_cidade', 100)->nullable();

            // Edificação
            $table->foreignId('edificacao_id')->constrained('edificacoes');
            $table->string('edificacao_nome', 100)->nullable();
            $table->string('edificacao_pavimentos', 3)->nullable();
            $table->string('edificacao_mezaninos', 3)->nullable();
            $table->string('edificacao_coberturas', 3)->nullable();
            $table->string('edificacao_areas_tecnicas', 3)->nullable();
            $table->string('edificacao_altura', 10)->nullable();
            $table->string('edificacao_area_total_construida', 10)->nullable();
            $table->string('edificacao_lotacao', 10)->nullable();
            $table->string('edificacao_carga_incendio', 10)->nullable();
            $table->string('edificacao_incendio_risco', 20)->nullable();
            $table->string('edificacao_grupo', 100)->nullable();
            $table->string('edificacao_ocupacao_uso', 100)->nullable();
            $table->string('edificacao_divisao', 100)->nullable();
            $table->string('edificacao_descricao', 255)->nullable();
            $table->string('edificacao_definicao', 255)->nullable();

            // Responsável
            $table->foreignId('responsavel_funcionario_id')->nullable()->constrained('funcionarios');
            $table->string('responsavel_funcionario_nome', 100)->nullable();
            $table->string('responsavel_funcionario_email', 100)->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vistorias_sistemas');
    }
};
