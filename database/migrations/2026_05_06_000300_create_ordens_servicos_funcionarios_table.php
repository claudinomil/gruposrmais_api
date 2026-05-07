<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdensServicosFuncionariosTable extends Migration
{
    public function up()
    {
        Schema::create('ordens_servicos_funcionarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ordem_servico_id')->constrained('ordens_servicos');
            $table->foreignId('funcionario_id')->constrained('funcionarios');
            $table->string('funcionario_item');
            $table->string('funcionario_nome');
            $table->foreignId('funcionario_veiculo_id')->constrained('veiculos');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ordens_servicos_funcionarios');
    }
}
