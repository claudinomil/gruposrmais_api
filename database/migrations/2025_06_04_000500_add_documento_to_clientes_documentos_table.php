<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDocumentoToClientesDocumentosTable extends Migration
{
    public function up()
    {
        Schema::table('clientes_documentos', function (Blueprint $table) {
            $table->integer('documento')->after('name')->nullable();
        });
    }

    public function down()
    {
        Schema::table('clientes_documentos', function (Blueprint $table) {
            $table->dropColumn('documento');
        });
    }
}
