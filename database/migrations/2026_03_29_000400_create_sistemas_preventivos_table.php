<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sistemas_preventivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medida_seguranca_id')->constrained('medidas_seguranca');
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sistemas_preventivos');
    }
};
