<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gameplays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('board_game_id')->index()->references('id')->on('board_games')->onDelete('cascade');
            $table->foreignId('user_id')->index()->references('id')->on('users')->onDelete('cascade');
            $table->date('date');
            $table->tinyInteger('count');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gameplays');
    }
};
