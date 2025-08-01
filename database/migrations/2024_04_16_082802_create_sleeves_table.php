<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sleeves', function (Blueprint $table) {
            $table->id();
            $table->string('mark', 150)->index();
            $table->string('name', 150)->index();
            $table->integer('height');
            $table->integer('width');
            $table->string('image_path')->nullable();
            $table->integer('quantity_available')->nullable()->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sleeves');
    }
};
