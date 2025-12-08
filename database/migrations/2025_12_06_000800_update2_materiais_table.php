<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('materiais', function (Blueprint $table) {
            $table->string('numero_patrimonio', 10)->nullable()->unique();
        });
    }
};
