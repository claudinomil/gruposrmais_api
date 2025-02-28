<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrigadasEscalasTable extends Migration
{
    public function up()
    {
        Schema::create('brigadas_escalas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brigada_id')->constrained('brigadas');

            //Campos vindos do Serviço do Cliente
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->string('cliente_nome');
            $table->foreignId('escala_tipo_id')->constrained('escala_tipos');
            $table->string('escala_tipo_nome');
            $table->integer('quantidade_alas');
            $table->integer('quantidade_brigadistas_por_ala');
            $table->integer('quantidade_brigadistas_total');
            $table->time('hora_inicio_ala');

            //Campos da Escala do dia
            $table->date('data_chegada');
            $table->time('hora_chegada');
            $table->date('data_saida');
            $table->time('hora_saida');
            $table->foreignId('funcionario_id')->constrained('funcionarios');
            $table->string('funcionario_nome');
            $table->integer('ala');

            $table->foreignId('escala_frequencia_id')->nullable()->constrained('escala_frequencias');
            $table->longText('foto_chegada_real')->nullable();
            $table->date('data_chegada_real')->nullable();
            $table->time('hora_chegada_real')->nullable();
            $table->longText('foto_saida_real')->nullable();
            $table->date('data_saida_real')->nullable();
            $table->time('hora_saida_real')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('brigadas_escalas');
    }
}
