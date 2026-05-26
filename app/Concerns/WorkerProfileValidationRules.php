<?php

namespace App\Concerns;

trait WorkerProfileValidationRules
{
    protected function workerProfileRules(): array
    {
        return [
            'name'                 => ['required', 'string', 'max:255'],
            'phone'                => ['nullable', 'string', 'max:30'],
            'birth_date'           => ['nullable', 'date', 'before:today'],
            'headline'             => ['nullable', 'string', 'max:120'],
            'bio'                  => ['nullable', 'string', 'max:1000'],
            'city'                 => ['nullable', 'string', 'max:100'],
            'province'             => ['nullable', 'string', 'max:100'],
            'available_immediately'=> ['nullable', 'in:yes,no,soon'],
            'work_modality'        => ['nullable', 'in:remote,onsite,hybrid'],
            'years_experience'     => ['nullable', 'integer', 'min:0', 'max:60'],
            'salary_period'        => ['nullable', 'in:MTH,HR'],
            'salary_min'           => ['nullable', 'integer', 'min:0'],
            'salary_max'           => ['nullable', 'integer', 'min:0', 'gte:salary_min'],
            'avatar'               => ['nullable', 'image', 'max:2048'],
            'cv'                   => ['nullable', 'mimes:pdf', 'max:10240'],
        ];
    }
}
