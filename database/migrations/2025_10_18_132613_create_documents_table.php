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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->date('date');
            $table->string('slug', 255)->unique();
            $table->text('description')->nullable();
            $table->string('file_path', 255);
            $table->string('file_mime', 100)->nullable();
            $table->string('file_extension', 20)->nullable();
            $table->bigInteger('file_size')->nullable();
            $table->boolean('is_published')->default(true);
            $table->boolean('is_protected')->default(false);
            $table->string('access_password', 255)->nullable();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('category_id')->nullable()->constrained('document_categories')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
