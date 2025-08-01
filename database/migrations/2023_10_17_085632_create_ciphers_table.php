<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ciphers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->index()->unique();
            $table->string('sub_name', 100)->index()->nullable();
            $table->string('slug', 100)->index()->unique();
            $table->longText('content')->nullable();
            $table->string('cover', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ciphers');
    }
};
