<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class DropFerramentasNotificacoesTables extends Migration
{
    public function up()
    {
        Schema::dropIfExists('notificacoes_lidas');
        Schema::dropIfExists('notificacoes');
        Schema::dropIfExists('ferramentas');
    }

    public function down()
    {}
}
