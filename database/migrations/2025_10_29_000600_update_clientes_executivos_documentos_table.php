<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateClientesExecutivosDocumentosTable extends Migration
{
    public function up()
    {
        Schema::table('clientes_executivos_documentos', function (Blueprint $table) {
            // Remove o campo "descricao e name"
            $table->dropColumn('descricao');
            $table->dropColumn('name');

            // Adiciona o campo documento_id
            $table->foreignId('documento_id')->constrained('documentos')->after('id');
        });
    }

    public function down()
    {
        Schema::table('clientes_executivos_documentos', function (Blueprint $table) {
            // Remove a foreign key e o campo
            $table->dropForeign(['documento_id']);
            $table->dropColumn('documento_id');

            // Recria o campo "descricao e name"
            $table->string('descricao')->nullable();
            $table->string('name')->nullable();
        });
    }
}
