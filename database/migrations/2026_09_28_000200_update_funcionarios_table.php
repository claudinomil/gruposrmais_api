<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('funcionarios', function (Blueprint $table) {
            $table->string('uniforme_gandola', 10)->nullable()->after('pix_chave');
            $table->string('uniforme_blusa', 10)->nullable()->after('uniforme_gandola');
            $table->string('uniforme_calca', 10)->nullable()->after('uniforme_blusa');
            $table->string('uniforme_coturno', 10)->nullable()->after('uniforme_calca');
        });
    }
};
