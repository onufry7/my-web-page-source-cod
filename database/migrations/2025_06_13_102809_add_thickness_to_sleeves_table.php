<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sleeves', function (Blueprint $table) {
            $table->integer('thickness')->after('width')->nullable()->comment('Thickness in microns');
        });
    }

    public function down(): void
    {
        Schema::table('sleeves', function (Blueprint $table) {
            $table->dropColumn('thickness');
        });
    }
};
