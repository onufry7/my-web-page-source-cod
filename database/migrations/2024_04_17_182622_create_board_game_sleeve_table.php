<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('board_game_sleeve', function (Blueprint $table) {
            $table->id();
            $table->foreignId('board_game_id')->index()->references('id')->on('board_games')->onDelete('cascade');
            $table->foreignId('sleeve_id')->index()->references('id')->on('sleeves')->onDelete('cascade');
            $table->integer('quantity');
            $table->boolean('sleeved')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('board_game_sleeve');
    }
};
