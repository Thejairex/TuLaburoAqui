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
        Schema::create('companies', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->string('legal_name');
            $table->string('display_name')->nullable();
            $table->string('tax_id_hash')->nullable();
            $table->string('industry')->nullable();
            $table->string('company_size')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->point('location')->nullable();
            $table->text('description')->nullable();
            // $table->string('logo_path')->nullable(); --- IGNORE ---
            $table->decimal('avg_rating', 10, 6)->nullable();
            $table->integer('ratings_count')->nullable();
            $table->string('status')->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
