<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn('numero_pavimentos');
            $table->dropColumn('altura');
            $table->dropColumn('area_total_construida');
            $table->dropColumn('lotacao');
            $table->dropColumn('carga_incendio');

            // Remover chave estrangeira e coluna
            $table->dropForeign('clientes_incendio_risco_id_foreign');
            $table->dropColumn('incendio_risco_id');

            // Remover chave estrangeira e coluna
            $table->dropForeign('clientes_edificacao_classificacao_id_foreign');
            $table->dropColumn('edificacao_classificacao_id');

            // E-mail para Aviso
            $table->string('email_avisos')->nullable();
        });
    }
};
