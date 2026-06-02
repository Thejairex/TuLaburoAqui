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
        Schema::create('reviews', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('job_application_id')->constrained('job_applications')->onDelete('cascade');
            $table->foreignUuid('reviewer_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignUuid('reviewed_user_id')->constrained('users')->onDelete('cascade');
            $table->integer('rating')->unsigned()->nullable();
            $table->text('comment')->nullable();
            $table->string('review_type')->nullable();
            $table->boolean('is_visible')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
