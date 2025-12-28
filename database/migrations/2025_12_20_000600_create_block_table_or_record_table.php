<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('block_table_or_record', function (Blueprint $table) {
            $table->id();
            $table->string('tabela');
            $table->unsignedBigInteger('tabela_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('session_hash')->nullable()->index();
            $table->timestamp('locked_at')->useCurrent();
            $table->timestamps();

            $table->index(['tabela', 'tabela_id']);
        });
    }
};
