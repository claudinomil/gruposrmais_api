<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitaTecnicaStatusTable extends Migration
{
    public function up()
    {
        Schema::create('visita_tecnica_status', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('visita_tecnica_status');
    }
}
