<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMateriaisEntradasTable extends Migration
{
    public function up()
    {
        Schema::create('materiais_entradas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas');
            $table->string('nf_numero', 30)->nullable();
            $table->string('nf_serie', 20)->nullable();
            $table->string('nf_chave_acesso')->nullable();
            $table->date('data_emissao')->nullable();
            $table->decimal('valor_total', 12, 2)->nullable();
            $table->decimal('valor_desconto', 12, 2)->nullable();

            $table->foreignId('fornecedor_id')->constrained('fornecedores');
            $table->string('fornecedor_nome')->nullable();
            $table->string('fornecedor_cnpj', 30)->nullable();
            $table->string('fornecedor_email')->nullable();
            $table->string('fornecedor_telefone', 15)->nullable();
            $table->string('fornecedor_celular', 15)->nullable();
            $table->string('fornecedor_logradouro')->nullable();
            $table->string('fornecedor_bairro')->nullable();
            $table->string('fornecedor_logradouro_numero', 15)->nullable();
            $table->string('fornecedor_logradouro_complemento')->nullable();
            $table->string('fornecedor_cidade')->nullable();
            $table->string('fornecedor_uf', 2)->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('materiais_entradas');
    }
}
