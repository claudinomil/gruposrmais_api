<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class DropAgrupamentosTables extends Migration
{
    public function up()
    {
        Schema::dropIfExists('agrupamentos');
    }
}
