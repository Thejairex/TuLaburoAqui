<?php

namespace App\Services;

use App\Models\User;

class WorkerProfileCompleteness
{
    public function items(User $user): array
    {
        $profile = $user->workerProfile;

        return [
            [
                'key' => 'avatar',
                'label' => 'Foto de perfil',
                'description' => 'Subí una foto tuya para que las empresas te identifiquen',
                'done' => $user->getFirstMedia('avatar') !== null,
                'icon' => 'photo_camera',
                'anchor' => 'foto-datos',
            ],
            [
                'key' => 'headline',
                'label' => 'Titular profesional',
                'description' => 'Describí tu rol en una línea (ej: "Electricista industrial")',
                'done' => filled($profile?->headline),
                'icon' => 'badge',
                'anchor' => 'foto-datos',
            ],
            [
                'key' => 'bio',
                'label' => 'Bio',
                'description' => 'Contá brevemente tu experiencia y qué buscás',
                'done' => filled($profile?->bio),
                'icon' => 'notes',
                'anchor' => 'foto-datos',
            ],
            [
                'key' => 'city',
                'label' => 'Ubicación',
                'description' => 'Indicá tu ciudad para que las empresas puedan encontrarte',
                'done' => filled($profile?->city),
                'icon' => 'location_on',
                'anchor' => 'foto-datos',
            ],
            [
                'key' => 'available_immediately',
                'label' => 'Disponibilidad',
                'description' => 'Indicá si estás disponible para trabajar ahora',
                'done' => filled($profile?->available_immediately),
                'icon' => 'schedule',
                'anchor' => 'disponibilidad',
            ],
            [
                'key' => 'work_modality',
                'label' => 'Modalidad de trabajo',
                'description' => 'Remoto, presencial o híbrido',
                'done' => filled($profile?->work_modality),
                'icon' => 'work',
                'anchor' => 'disponibilidad',
            ],
            [
                'key' => 'cv',
                'label' => 'CV (PDF)',
                'description' => 'Subí tu currículum actualizado en formato PDF',
                'done' => $profile?->getFirstMedia('cv') !== null,
                'icon' => 'description',
                'anchor' => 'cv',
            ],
            [
                'key' => 'skills',
                'label' => 'Habilidades',
                'description' => 'Agregá al menos una habilidad técnica o profesional',
                'done' => (bool) $profile?->skills()->exists(),
                'icon' => 'construction',
                'anchor' => 'habilidades',
            ],
        ];
    }

    public function percentage(User $user): int
    {
        $items = $this->items($user);
        $done = count(array_filter($items, fn ($i) => $i['done']));

        return (int) round($done / count($items) * 100);
    }

    public function pending(User $user): array
    {
        return array_values(array_filter($this->items($user), fn ($i) => ! $i['done']));
    }
}
