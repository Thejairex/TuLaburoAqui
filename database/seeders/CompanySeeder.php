<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyMember;
use App\Models\Skill;
use App\Models\User;
use App\Services\JobPostService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name'               => 'TechCorp Argentina',
            'email'              => 'empresa@demo.com',
            'password'           => Hash::make('password'),
            'role'               => 'employer',
            'email_verified_at'  => now(),
        ]);

        $company = Company::create([
            'legal_name'   => 'TechCorp Argentina S.A.',
            'display_name' => 'TechCorp',
            'slug'         => Company::generateUniqueSlug('TechCorp'),
            'industry'     => 'Tecnología',
            'company_size' => '11-50',
            'city'         => 'Buenos Aires',
            'province'     => 'Buenos Aires',
            'description'  => 'Empresa de desarrollo de software especializada en soluciones web y mobile. Trabajamos con tecnologías modernas y un equipo apasionado por la innovación.',
            'website'      => 'https://techcorp.com.ar',
            'email'        => 'rrhh@techcorp.com.ar',
            'status'       => 'active',
        ]);

        CompanyMember::create([
            'company_id' => $company->id,
            'user_id'    => $user->id,
            'role'       => 'admin',
            'is_owner'   => true,
        ]);

        $skills = Skill::whereIn('slug', [
            'php', 'laravel', 'javascript', 'react', 'vue-js',
            'node-js', 'mysql', 'docker', 'git', 'python',
        ])->get()->keyBy('slug');

        $service = app(JobPostService::class);

        $posts = [
            [
                'data' => [
                    'title'          => 'Desarrollador PHP / Laravel Senior',
                    'description'    => "Buscamos un desarrollador senior con sólida experiencia en PHP y Laravel para sumarse a nuestro equipo de backend.\n\nResponsabilidades:\n- Diseñar e implementar APIs RESTful\n- Revisión de código y mentoring a desarrolladores junior\n- Participar en decisiones de arquitectura\n\nRequisitos:\n- +4 años de experiencia con PHP y Laravel\n- Conocimiento de Docker y CI/CD\n- Buen manejo de MySQL",
                    'category'       => 'Tecnología',
                    'seniority'      => 'senior',
                    'contract_type'  => 'full-time',
                    'work_modality'  => 'hybrid',
                    'city'           => 'Buenos Aires',
                    'province'       => 'Buenos Aires',
                    'salary_min'     => 2500,
                    'salary_max'     => 3500,
                    'salary_visible' => true,
                    'vacancies'      => 2,
                    'status'         => 'published',
                ],
                'skills' => [
                    ['slug' => 'php',    'required' => true,  'priority' => 1],
                    ['slug' => 'laravel','required' => true,  'priority' => 2],
                    ['slug' => 'mysql',  'required' => true,  'priority' => 3],
                    ['slug' => 'docker', 'required' => false, 'priority' => 4],
                ],
            ],
            [
                'data' => [
                    'title'          => 'Frontend Developer React',
                    'description'    => "Nos encontramos en la búsqueda de un desarrollador frontend con experiencia en React para trabajar en nuestros productos SaaS.\n\nResponsabilidades:\n- Desarrollar componentes reutilizables en React\n- Colaborar con diseño UX/UI\n- Optimizar performance de la aplicación\n\nRequisitos:\n- +2 años de experiencia con React\n- Conocimiento de JavaScript moderno (ES6+)\n- Experiencia con Git y trabajo en equipo",
                    'category'       => 'Tecnología',
                    'seniority'      => 'mid',
                    'contract_type'  => 'full-time',
                    'work_modality'  => 'remote',
                    'city'           => 'Buenos Aires',
                    'province'       => 'Buenos Aires',
                    'salary_min'     => 1800,
                    'salary_max'     => 2800,
                    'salary_visible' => true,
                    'vacancies'      => 1,
                    'status'         => 'published',
                ],
                'skills' => [
                    ['slug' => 'react',      'required' => true,  'priority' => 1],
                    ['slug' => 'javascript', 'required' => true,  'priority' => 2],
                    ['slug' => 'git',        'required' => true,  'priority' => 3],
                ],
            ],
            [
                'data' => [
                    'title'          => 'Desarrollador Full Stack Junior',
                    'description'    => "Oportunidad ideal para desarrolladores con ganas de crecer profesionalmente en un equipo dinámico.\n\nResponsabilidades:\n- Colaborar en el desarrollo de nuevas funcionalidades\n- Resolver bugs y mejorar el código existente\n- Aprender y aplicar buenas prácticas de desarrollo\n\nRequisitos:\n- Conocimientos de PHP o JavaScript\n- Ganas de aprender y trabajo en equipo\n- Se valora experiencia con Laravel o Vue.js",
                    'category'       => 'Tecnología',
                    'seniority'      => 'junior',
                    'contract_type'  => 'full-time',
                    'work_modality'  => 'on-site',
                    'city'           => 'Córdoba',
                    'province'       => 'Córdoba',
                    'salary_min'     => 900,
                    'salary_max'     => 1400,
                    'salary_visible' => true,
                    'vacancies'      => 3,
                    'status'         => 'published',
                ],
                'skills' => [
                    ['slug' => 'php',        'required' => false, 'priority' => 1],
                    ['slug' => 'javascript', 'required' => false, 'priority' => 2],
                    ['slug' => 'vue-js',     'required' => false, 'priority' => 3],
                    ['slug' => 'git',        'required' => true,  'priority' => 4],
                ],
            ],
            [
                'data' => [
                    'title'          => 'Data Analyst / Python',
                    'description'    => "Buscamos un analista de datos para ayudarnos a entender mejor el comportamiento de nuestros usuarios y optimizar nuestros productos.\n\nResponsabilidades:\n- Analizar grandes volúmenes de datos\n- Crear dashboards e informes para el equipo de producto\n- Identificar tendencias y oportunidades de mejora\n\nRequisitos:\n- Experiencia con Python y pandas\n- Conocimiento de SQL\n- Capacidad de comunicar hallazgos de forma clara",
                    'category'       => 'Tecnología',
                    'seniority'      => 'mid',
                    'contract_type'  => 'contract',
                    'work_modality'  => 'remote',
                    'city'           => 'Buenos Aires',
                    'province'       => 'Buenos Aires',
                    'salary_min'     => 1500,
                    'salary_max'     => 2200,
                    'salary_visible' => false,
                    'vacancies'      => 1,
                    'status'         => 'published',
                ],
                'skills' => [
                    ['slug' => 'python', 'required' => true,  'priority' => 1],
                    ['slug' => 'mysql',  'required' => true,  'priority' => 2],
                ],
            ],
            [
                'data' => [
                    'title'          => 'DevOps Engineer',
                    'description'    => "Incorporamos un DevOps para fortalecer nuestra infraestructura y procesos de CI/CD.\n\nResponsabilidades:\n- Mantener y mejorar la infraestructura cloud\n- Implementar pipelines de CI/CD\n- Monitoreo y resolución de incidentes\n\nRequisitos:\n- Experiencia con Docker y Kubernetes\n- Conocimiento de herramientas CI/CD (GitHub Actions, Jenkins)\n- Manejo de Linux",
                    'category'       => 'Tecnología',
                    'seniority'      => 'senior',
                    'contract_type'  => 'full-time',
                    'work_modality'  => 'remote',
                    'city'           => 'Buenos Aires',
                    'province'       => 'Buenos Aires',
                    'salary_min'     => 3000,
                    'salary_max'     => 4500,
                    'salary_visible' => true,
                    'vacancies'      => 1,
                    'status'         => 'draft',
                ],
                'skills' => [
                    ['slug' => 'docker', 'required' => true, 'priority' => 1],
                    ['slug' => 'git',    'required' => true, 'priority' => 2],
                ],
            ],
        ];

        foreach ($posts as $post) {
            $skillsPayload = collect($post['skills'])
                ->filter(fn ($s) => isset($skills[$s['slug']]))
                ->map(fn ($s) => [
                    'skill_id' => $skills[$s['slug']]->id,
                    'required' => $s['required'],
                    'priority' => $s['priority'],
                ])
                ->values()
                ->all();

            $service->create($company, $user, $post['data'], $skillsPayload);
        }
    }
}
