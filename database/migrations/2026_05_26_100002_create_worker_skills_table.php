<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('worker_skills', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('worker_profile_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('skill_id')->constrained()->cascadeOnDelete();
            $table->integer('level')->default(2); // 1 = Beginner, 2 = Intermediate, 3 = Advanced for now
            $table->unsignedInteger('experience_years')->nullable();
            $table->timestamps();
            $table->unique(['worker_profile_id', 'skill_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('worker_skills');
    }
};
