<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMapasItensTable extends Migration
{
    public function up()
    {
        Schema::create('mapas_itens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mapa_id')->constrained('mapas');

            //Se for um Ponto
            $table->foreignId('mapa_ponto_tipo_id')->constrained('mapas_pontos_tipos');
            $table->string('ponto_nome');
            $table->string('ponto_descricao')->nullable();
            $table->string('ponto_latitude');
            $table->string('ponto_longitude');
            $table->string('ponto_icone');

            //Se for uma Rota
            $table->foreignId('ordem_servico_id')->nullable()->constrained('ordens_servicos');
            $table->string('rota_nome');
            $table->string('rota_descricao')->nullable();

            $table->string('rota_origem_nome');
            $table->string('rota_origem_descricao')->nullable();
            $table->string('rota_origem_latitude');
            $table->string('rota_origem_longitude');
            $table->string('rota_origem_cep')->nullable();
            $table->string('rota_origem_numero')->nullable();
            $table->string('rota_origem_complemento')->nullable();
            $table->string('rota_origem_logradouro')->nullable();
            $table->string('rota_origem_bairro')->nullable();
            $table->string('rota_origem_localidade')->nullable();
            $table->string('rota_origem_uf')->nullable();

            $table->string('rota_destino_nome');
            $table->string('rota_destino_descricao')->nullable();
            $table->string('rota_destino_latitude');
            $table->string('rota_destino_longitude');
            $table->string('rota_destino_cep')->nullable();
            $table->string('rota_destino_numero')->nullable();
            $table->string('rota_destino_complemento')->nullable();
            $table->string('rota_destino_logradouro')->nullable();
            $table->string('rota_destino_bairro')->nullable();
            $table->string('rota_destino_localidade')->nullable();
            $table->string('rota_destino_uf')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mapas_itens');
    }
}
