<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersConfiguracoesTable extends Migration
{
    public function up()
    {
        Schema::create('users_configuracoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('empresa_id')->nullable()->constrained('empresas');
            $table->foreignId('grupo_id')->nullable()->constrained('grupos');
            $table->foreignId('situacao_id')->nullable()->constrained('situacoes');
            $table->foreignId('sistema_acesso_id')->nullable()->constrained('sistema_acessos');
            $table->string('layout_mode')->nullable();
            $table->string('layout_style')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users_configuracoes');
    }
}
