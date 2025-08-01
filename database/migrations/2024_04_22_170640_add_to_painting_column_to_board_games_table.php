<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('board_games', function (Blueprint $table) {
            $table->boolean('to_painting')->after('need_insert')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('board_games', function (Blueprint $table) {
            $table->dropColumn('to_painting');
        });
    }
};
