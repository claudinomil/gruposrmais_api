<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('clientes_documentos', function (Blueprint $table) {
            $table->renameColumn('data_documento', 'data_emissao');
            $table->string('descricao')->nullable();
            $table->date('data_vencimento')->nullable();
            $table->date('data_ultimo_aviso')->nullable();
        });

        Schema::table('clientes_executivos_documentos', function (Blueprint $table) {
            $table->renameColumn('data_documento', 'data_emissao');
            $table->string('descricao')->nullable();
            $table->date('data_vencimento')->nullable();
            $table->date('data_ultimo_aviso')->nullable();
        });

        Schema::table('funcionarios_documentos', function (Blueprint $table) {
            $table->renameColumn('data_documento', 'data_emissao');
            $table->string('descricao')->nullable();
            $table->date('data_vencimento')->nullable();
            $table->date('data_ultimo_aviso')->nullable();
        });
    }
};
