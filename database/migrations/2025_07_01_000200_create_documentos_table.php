<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosTable extends Migration
{
    public function up()
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('documento_submodulo_id')->constrained('documento_submodulos');
            $table->foreignId('documento_fonte_id')->constrained('documento_fontes');
            $table->integer('ordem');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('documentos');
    }
}
