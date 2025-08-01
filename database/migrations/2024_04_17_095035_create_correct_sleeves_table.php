<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('correct_sleeves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sleeve_id')->index()->references('id')->on('sleeves')->onDelete('cascade');
            $table->string('description')->nullable();
            $table->integer('quantity_before')->nullable();
            $table->integer('quantity_after')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('correct_sleeves');
    }
};
