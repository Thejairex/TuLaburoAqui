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
        Schema::create('job_posts', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->foreignUuid('company_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('created_by_user_id')->constrained('users')->onDelete('set null');
            $table->string('title');
            $table->text('description');
            $table->string('category')->nullable(); # Enum: software, marketing, sales, design, etc.
            $table->string('seniority')->nullable(); # Enum: junior, mid, senior, lead
            $table->string('contract_type')->nullable(); # Enum: full-time, part-time, contract, internship, freelance
            $table->string('work_modality')->nullable(); # Enum: on-site, remote, hybrid
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('location')->nullable(); # For remote jobs, this can be "Remote" or a specific region
            $table->decimal('salary_min', 10, 2)->nullable();
            $table->decimal('salary_max', 10, 2)->nullable();
            $table->boolean('salary_visible')->default(false);
            $table->integer('vacancies')->default(1);
            $table->boolean('is_featured')->default(false);
            $table->string('status')->default('open'); # Enum: open, closed, paused

            $table->timestamp('published_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};
