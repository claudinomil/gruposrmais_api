<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdensServicosEquipesTable extends Migration
{
    public function up()
    {
        Schema::create('ordens_servicos_equipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ordem_servico_id')->constrained('ordens_servicos');
            $table->foreignId('equipe_funcionario_id')->constrained('funcionarios');
            $table->string('equipe_funcionario_item');
            $table->string('equipe_funcionario_nome');
            $table->string('equipe_funcionario_funcao');
            $table->foreignId('equipe_funcionario_veiculo_id')->constrained('veiculos');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ordens_servicos_equipes');
    }
}
