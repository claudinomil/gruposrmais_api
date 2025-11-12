<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMapasPontosInteresseTable extends Migration
{
    public function up()
    {
        Schema::table('mapas_pontos_interesse', function (Blueprint $table) {
            $table->string('telefone_1')->nullable();
            $table->string('telefone_2')->nullable();
            $table->foreignId('ponto_natureza_id')->nullable()->constrained('pontos_naturezas');
        });
    }
}