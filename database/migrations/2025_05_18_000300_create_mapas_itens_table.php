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

            /*
             * item_tipo_id
             * 1 : POI Sistema Individual
             * 2 : POI Sistema Grupo
             * 3 : Ponto Personalizado
             * 4 : POI Google Grupo
             * 5 : Rota Personalizada
             * 6 : Rotas Órdem Serviço
             * 7 : Polígonos Comunidades
             */
            $table->integer('item_tipo_id');

            $table->foreignId('mapa_ponto_tipo_id')->nullable()->constrained('mapas_pontos_tipos');
            $table->foreignId('ordem_servico_id')->nullable()->constrained('ordens_servicos');
            $table->string('item_name')->nullable();
            $table->string('item_descricao')->nullable();
            $table->string('google_grupo')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('icone')->nullable();
            $table->string('origem_cep')->nullable();
            $table->string('origem_numero')->nullable();
            $table->string('origem_complemento')->nullable();
            $table->string('origem_logradouro')->nullable();
            $table->string('origem_bairro')->nullable();
            $table->string('origem_localidade')->nullable();
            $table->string('origem_uf')->nullable();
            $table->string('destino_cep')->nullable();
            $table->string('destino_numero')->nullable();
            $table->string('destino_complemento')->nullable();
            $table->string('destino_logradouro')->nullable();
            $table->string('destino_bairro')->nullable();
            $table->string('destino_localidade')->nullable();
            $table->string('destino_uf')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mapas_itens');
    }
}
