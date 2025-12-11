<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstoquesTable extends Migration
{
    public function up()
    {
        Schema::create('estoques', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('ordem');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('estoques');
    }
}
