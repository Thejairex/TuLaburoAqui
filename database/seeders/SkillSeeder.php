<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            // Backend
            ['name' => 'PHP', 'category' => 'backend'],
            ['name' => 'Laravel', 'category' => 'backend'],
            ['name' => 'Python', 'category' => 'backend'],
            ['name' => 'Django', 'category' => 'backend'],
            ['name' => 'Node.js', 'category' => 'backend'],
            ['name' => 'Java', 'category' => 'backend'],
            ['name' => 'Go', 'category' => 'backend'],
            // Frontend
            ['name' => 'JavaScript', 'category' => 'frontend'],
            ['name' => 'TypeScript', 'category' => 'frontend'],
            ['name' => 'React', 'category' => 'frontend'],
            ['name' => 'Vue.js', 'category' => 'frontend'],
            ['name' => 'Livewire', 'category' => 'frontend'],
            ['name' => 'Tailwind CSS', 'category' => 'frontend'],
            ['name' => 'HTML/CSS', 'category' => 'frontend'],
            // DevOps
            ['name' => 'Docker', 'category' => 'devops'],
            ['name' => 'Kubernetes', 'category' => 'devops'],
            ['name' => 'AWS', 'category' => 'devops'],
            ['name' => 'CI/CD', 'category' => 'devops'],
            ['name' => 'Linux', 'category' => 'devops'],
            // Mobile
            ['name' => 'React Native', 'category' => 'mobile'],
            ['name' => 'Flutter', 'category' => 'mobile'],
            ['name' => 'Swift', 'category' => 'mobile'],
            // Data
            ['name' => 'SQL', 'category' => 'data'],
            ['name' => 'PostgreSQL', 'category' => 'data'],
            ['name' => 'MySQL', 'category' => 'data'],
            ['name' => 'MongoDB', 'category' => 'data'],
            // Design
            ['name' => 'Figma', 'category' => 'design'],
            ['name' => 'UX/UI', 'category' => 'design'],
            // Soft skills
            ['name' => 'Liderazgo', 'category' => 'soft-skills'],
            ['name' => 'Trabajo en equipo', 'category' => 'soft-skills'],
        ];

        foreach ($skills as $skill) {
            Skill::firstOrCreate(
                ['slug' => Str::slug($skill['name'])],
                ['name' => $skill['name'], 'category' => $skill['category']]
            );
        }
    }
}
