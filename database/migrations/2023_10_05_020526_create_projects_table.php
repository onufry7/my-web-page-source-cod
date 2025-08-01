<?php

use App\Enums\ProjectCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name', 160)->index()->unique();
            $table->string('slug')->index()->unique();
            $table->string('url', 255);
            $table->string('git', 255)->nullable();
            $table->enum('category', array_column(ProjectCategory::cases(), 'value'))->nullable();
            $table->string('image_path', 255)->nullable();
            $table->longText('description')->nullable();
            $table->boolean('for_registered')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
