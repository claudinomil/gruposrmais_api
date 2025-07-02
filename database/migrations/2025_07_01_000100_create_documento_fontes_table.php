<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentoFontesTable extends Migration
{
    public function up()
    {
        Schema::create('documento_fontes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('ordem');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('documento_fontes');
    }
}
