<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesServicosTable extends Migration
{
    public function up()
    {
        Schema::create('clientes_servicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->foreignId('servico_id')->constrained('servicos');
            $table->foreignId('servico_status_id')->constrained('servico_status');
            $table->foreignId('responsavel_funcionario_id')->nullable()->constrained('funcionarios');

            $table->integer('quantidade')->nullable()->default(0);
            $table->date('data_inicio')->nullable();
            $table->date('data_fim')->nullable();
            $table->date('data_vencimento')->nullable();
            $table->decimal('valor', 20, 2)->nullable()->default(0);

            //Campos para o Serviço de Brigada de Incêndio Id=1'''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $table->foreignId('bi_escala_tipo_id')->nullable()->constrained('escala_tipos');
            $table->integer('bi_quantidade_alas_escala')->nullable();
            $table->integer('bi_quantidade_brigadistas_por_ala')->nullable();
            $table->integer('bi_quantidade_brigadistas_total')->nullable();
            $table->time('bi_hora_inicio_ala')->nullable();
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clientes_servicos');
    }
}
