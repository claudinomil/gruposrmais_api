<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('uniformes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('funcionarios_campo');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('uniformes');
    }
};
