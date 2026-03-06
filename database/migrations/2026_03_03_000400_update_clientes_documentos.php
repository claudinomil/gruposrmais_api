<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('clientes_documentos', function (Blueprint $table) {
            $table->string('caminho')->nullable()->change();
        });
    }
};
