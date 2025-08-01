<?php

use App\Enums\BoardGameType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('board_games', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->index()->unique();
            $table->string('slug', 255)->index()->unique();
            $table->longText('description')->nullable();
            $table->foreignId('publisher_id')->nullable()->index()->references('id')->on('publishers')->nullOnDelete();
            $table->foreignId('original_publisher_id')->nullable()->index()->references('id')->on('publishers')->nullOnDelete();
            $table->tinyInteger('age')->nullable();
            $table->tinyInteger('min_players')->nullable();
            $table->tinyInteger('max_players')->nullable();
            $table->smallInteger('game_time')->nullable();
            $table->string('box_img', 255)->nullable();
            $table->string('instruction', 255)->nullable();
            $table->string('video_url', 255)->nullable();
            $table->string('bgg_url', 255)->nullable();
            $table->string('planszeo_url', 255)->nullable();
            $table->enum('type', array_column(BoardGameType::cases(), 'value'))->default(BoardGameType::BaseGame->value);
            $table->foreignId('base_game_id')->nullable()->references('id')->on('board_games')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('board_games', function (Blueprint $table) {
            $table->dropForeign(['publisher_id']);
            $table->dropForeign(['original_publisher_id']);
            $table->dropForeign(['base_game_id']);
            $table->dropIfExists();
        });
    }
};
