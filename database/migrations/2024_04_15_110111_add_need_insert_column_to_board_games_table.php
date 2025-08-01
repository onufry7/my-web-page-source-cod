<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('board_games', function (Blueprint $table) {
            $table->boolean('need_insert')->after('base_game_id')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('board_games', function (Blueprint $table) {
            $table->dropColumn('need_insert');
        });
    }
};
