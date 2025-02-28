<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cliente_servicos_brigadistas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_servico_id')->constrained('clientes_servicos');
            $table->foreignId('funcionario_id')->constrained('funcionarios');
            $table->string('funcionario_nome');
            $table->integer('ala');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cliente_servicos_brigadistas');
    }
};
