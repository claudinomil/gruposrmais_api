<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('mapas_preventivos', function (Blueprint $table) {
            $table->dropForeign(['sistema_preventivo_id']);
            $table->dropColumn('sistema_preventivo_id');
        });
    }
};
