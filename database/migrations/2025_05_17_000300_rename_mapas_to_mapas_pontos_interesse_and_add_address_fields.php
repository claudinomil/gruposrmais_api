<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameMapasToMapasPontosInteresseAndAddAddressFields extends Migration
{
    public function up()
    {
        // Renomeia a tabela
        Schema::rename('mapas', 'mapas_pontos_interesse');

        // Adiciona os campos antes de latitude
        Schema::table('mapas_pontos_interesse', function (Blueprint $table) {
            $table->string('cep')->nullable()->after('descricao');
            $table->string('numero')->nullable()->after('cep');
            $table->string('complemento')->nullable()->after('numero');
            $table->string('logradouro')->nullable()->after('complemento');
            $table->string('bairro')->nullable()->after('logradouro');
            $table->string('localidade')->nullable()->after('bairro');
            $table->string('uf')->nullable()->after('localidade');
        });
    }

    public function down()
    {
        // Remove os campos adicionados
        Schema::table('mapas_pontos_interesse', function (Blueprint $table) {
            $table->dropColumn([
                'cep', 'numero', 'complemento',
                'logradouro', 'bairro', 'localidade', 'uf'
            ]);
        });

        // Renomeia de volta a tabela
        Schema::rename('mapas_pontos_interesse', 'mapas');
    }
}
