<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('edificacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->string('cliente_nome', 100)->nullable();
            $table->string('cliente_telefone', 15)->nullable();
            $table->string('cliente_celular', 15)->nullable();
            $table->string('cliente_email', 100)->nullable();
            $table->string('cliente_logradouro', 150)->nullable();
            $table->string('cliente_bairro', 100)->nullable();
            $table->string('cliente_cidade', 100)->nullable();
            $table->string('name')->nullable();
            $table->integer('pavimentos')->default(0);
            $table->integer('mezaninos')->default(0);
            $table->integer('coberturas')->default(0);
            $table->integer('areas_tecnicas')->default(0);
            $table->decimal('altura')->nullable();
            $table->decimal('area_total_construida')->nullable();
            $table->integer('lotacao')->nullable();
            $table->integer('carga_incendio')->nullable();
            $table->foreignId('incendio_risco_id')->nullable()->constrained('incendio_riscos');
            $table->foreignId('edificacao_classificacao_id')->nullable()->constrained('edificacao_classificacoes');
            $table->string('grupo', 150)->nullable();
            $table->string('ocupacao_uso', 150)->nullable();
            $table->string('divisao', 150)->nullable();
            $table->string('descricao', 150)->nullable();
            $table->string('definicao', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('edificacoes');
    }
};
