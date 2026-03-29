<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('clientes_sistemas_preventivos', function (Blueprint $table) {
            $table->foreignId('edificacao_local_id')->nullable()->after('cliente_id')->constrained('edificacoes_locais');
        });
    }
};
