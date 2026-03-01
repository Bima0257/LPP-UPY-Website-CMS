<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->nullable();
            $table->text('description')->nullable();
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->text('purpose')->nullable();
            $table->string('thumbnail', 200)->nullable();
            $table->string('image', 200)->nullable();
            $table->string('favicon', 200)->nullable();
            $table->string('black_logo', 200)->nullable();
            $table->string('white_logo', 200)->nullable();
            $table->text('address')->nullable();
            $table->string('email', 150)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('youtube_link', 255)->nullable();
            $table->string('instagram_link', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
