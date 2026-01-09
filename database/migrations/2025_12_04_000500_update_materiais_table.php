<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('materiais', function (Blueprint $table) {
            $table->string('fotografia')->default('build/assets/images/produtos/produto-0.png');
            $table->foreignId('cor_id')->nullable()->constrained('cores');
            $table->string('ca', 20)->nullable();
        });
    }
};
