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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->string('divisi', 100)->nullable();
            $table->string('foto', 200)->nullable();
            $table->string('instagram_link', 255)->nullable();
            $table->string('linkedin_link', 255)->nullable();
            $table->string('facebook_link', 255)->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
