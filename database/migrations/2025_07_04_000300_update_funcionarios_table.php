<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFuncionariosTable extends Migration
{
    public function up()
    {
        Schema::table('funcionarios', function (Blueprint $table) {
            $table->dropForeign(['empresa_id']);
            $table->dropColumn('empresa_id');

            $table->foreignId('tomador_servico_cliente_id')->nullable()->constrained('clientes');
            $table->string('nome_profissional')->nullable();
        });
    }

    public function down()
    {
        Schema::table('funcionarios', function (Blueprint $table) {
            $table->foreignId('empresa_id')->constrained('empresas');

            $table->dropColumn('tomador_servico_cliente_id');
            $table->dropColumn('nome_profissional');
        });
    }
}
