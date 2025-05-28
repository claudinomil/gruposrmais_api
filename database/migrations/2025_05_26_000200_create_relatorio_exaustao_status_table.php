<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelatorioExaustaoStatusTable extends Migration
{
    public function up()
    {
        Schema::create('relatorio_exaustao_status', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('relatorio_exaustao_status');
    }
}
