<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class DropUsersConfiguracoesTables extends Migration
{
    public function up()
    {
        Schema::dropIfExists('users_configuracoes');
    }

    public function down()
    {}
}
