<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_post_skills', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('job_post_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('skill_id')->constrained()->cascadeOnDelete();
            $table->boolean('required')->default(true);
            $table->integer('priority')->default(0);
            $table->timestamps();
            $table->unique(['job_post_id', 'skill_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_post_skills');
    }
};
