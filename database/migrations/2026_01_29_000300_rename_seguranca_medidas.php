<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Renomeia a tabela
        Schema::rename('seguranca_medidas', 'medidas_seguranca');
    }
};
