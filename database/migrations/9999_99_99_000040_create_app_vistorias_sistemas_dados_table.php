<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('app_vistorias_sistemas_dados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('app_vistoria_sistema_id')->constrained('app_vistorias_sistemas');

            // Cliente Sistema Preventivo
            $table->foreignId('cliente_sistema_preventivo_id')->constrained('clientes_sistemas_preventivos')->index('vsd_cliente_sistema_preventivo_id');
            $table->string('sistema_preventivo_numero', 10)->nullable();

            // Sistema Preventivo
            $table->foreignId('sistema_preventivo_id')->constrained('sistemas_preventivos');
            $table->string('sistema_preventivo_nome', 100)->nullable();

            // Edificação Local
            $table->foreignId('edificacao_local_id')->constrained('edificacoes_locais');
            $table->string('edificacao_local_nome', 100)->nullable();

            // Edificação Nível
            $table->foreignId('edificacao_nivel_id')->constrained('edificacoes_niveis');
            $table->string('edificacao_nivel_nome', 100)->nullable();

            // Vistoria
            $table->integer('resposta')->nullable();
            $table->text('observacao')->nullable();
            $table->text('fotografia_1')->nullable();
            $table->text('fotografia_2')->nullable();
            $table->text('fotografia_3')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('app_vistorias_sistemas_dados');
    }
};
