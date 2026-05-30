<?php

namespace Database\Factories;

use App\Models\JobPost;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<JobPost>
 *
 * Nota: company_id y created_by_user_id deben proveerse al usar la factory,
 * por ejemplo: JobPost::factory()->for($company)->create(['created_by_user_id' => $user->id]).
 */
class JobPostFactory extends Factory
{
    public function definition(): array
    {
        $min = fake()->numberBetween(800, 2500);

        return [
            'title' => fake()->jobTitle(),
            'description' => fake()->paragraphs(3, true),
            'category' => fake()->randomElement(['Tecnología', 'Construcción', 'Ventas', 'Administración', 'Logística']),
            'seniority' => fake()->randomElement(['junior', 'mid', 'senior', 'lead']),
            'contract_type' => fake()->randomElement(['full-time', 'part-time', 'contract', 'internship', 'freelance']),
            'work_modality' => fake()->randomElement(['on-site', 'remote', 'hybrid']),
            'city' => fake()->city(),
            'province' => fake()->state(),
            'salary_min' => $min,
            'salary_max' => $min + fake()->numberBetween(500, 2000),
            'salary_visible' => fake()->boolean(70),
            'vacancies' => fake()->numberBetween(1, 5),
            'is_featured' => false,
            'status' => 'draft',
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => [
            'status' => 'published',
            'published_at' => now(),
        ]);
    }
}
