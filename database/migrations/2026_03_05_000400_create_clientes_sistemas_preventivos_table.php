<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('clientes_sistemas_preventivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->foreignId('medida_seguranca_id')->constrained('medidas_seguranca');
            $table->string('name');
            $table->string('sistema_preventivo_numero', 7)->unique();
            $table->text('descricao')->nullable();
            $table->string('fotografia')->default('build/assets/images/clientes/sistema_preventivo-0.png');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clientes_sistemas_preventivos');
    }
};
