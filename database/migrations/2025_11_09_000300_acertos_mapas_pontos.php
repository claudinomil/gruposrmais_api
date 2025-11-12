<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AcertosMapasPontos extends Migration
{
    public function up()
    {
        // Renomear tabela mapas_pontos_interesse
        Schema::rename('mapas_pontos_interesse', 'pontos_interesse');

        // Renomear tabela mapas_pontos_tipos
        Schema::rename('mapas_pontos_tipos', 'pontos_tipos');

        // Fazendo alterações na tabela mapas_itens''''''''''''''''''''''''''''''''''''''''''''''''''
        Schema::table('mapas_itens', function (Blueprint $table) {
            $table->dropForeign(['mapa_ponto_tipo_id']);
            $table->renameColumn('mapa_ponto_tipo_id', 'ponto_tipo_id');
        });

        Schema::table('mapas_itens', function (Blueprint $table) {
            $table->foreign('ponto_tipo_id')->references('id')->on('pontos_tipos');
        });
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Fazendo alterações na tabela pontos_interesse'''''''''''''''''''''''''''''''''''''''''''''
        Schema::table('pontos_interesse', function (Blueprint $table) {
            $table->renameColumn('mapa_ponto_tipo_id', 'ponto_tipo_id');
        });

        Schema::table('pontos_interesse', function (Blueprint $table) {
            $table->foreign('ponto_tipo_id')->references('id')->on('pontos_tipos');
        });
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}