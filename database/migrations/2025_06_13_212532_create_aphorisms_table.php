<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aphorisms', function (Blueprint $table) {
            $table->id();
            $table->string('sentence', 255);
            $table->string('author', 120)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aphorisms');
    }
};
