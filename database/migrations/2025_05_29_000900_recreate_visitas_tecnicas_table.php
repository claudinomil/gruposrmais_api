<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecreateVisitasTecnicasTable extends Migration
{
    public function up()
    {
        // Remove tabelas se existirem
        Schema::dropIfExists('visitas_tecnicas_seguranca_medidas');
        Schema::dropIfExists('visitas_tecnicas');

        Schema::create('visitas_tecnicas', function (Blueprint $table) {
            // Informações Gerais
            $table->id();
            $table->integer('numero_visita_tecnica')->unique();
            $table->integer('ano_visita_tecnica');
            $table->foreignId('visita_tecnica_tipo_id')->constrained('visita_tecnica_tipos');
            $table->foreignId('visita_tecnica_status_id')->constrained('visita_tecnica_status');
            $table->date('data_abertura')->nullable(); // Data de criação da VT
            $table->time('hora_abertura')->nullable(); // Hora de criação da VT
            $table->date('data_prevista')->nullable(); // Data prevista para conclusão
            $table->time('hora_prevista')->nullable(); // Hora prevista para conclusão
            $table->date('data_conclusao')->nullable(); // Data real da conclusão
            $table->time('hora_conclusao')->nullable(); // Hora real da conclusão
            $table->date('data_finalizacao')->nullable(); // Data real da finalização
            $table->time('hora_finalizacao')->nullable(); // Hora real da finalização

            // Informações do Cliente
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
        Schema::dropIfExists('visitas_tecnicas_seguranca_medidas');
        Schema::dropIfExists('visitas_tecnicas');
    }
}
