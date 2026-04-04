<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('clientes_sistemas_preventivos', function (Blueprint $table) {
            $table->dropForeign(['medida_seguranca_id']);
            $table->dropColumn('medida_seguranca_id');

            $table->dropColumn('name');

            $table->foreignId('sistema_preventivo_id')->nullable()->after('edificacao_local_id')->constrained('sistemas_preventivos');
        });
    }
};
