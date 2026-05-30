<?php

namespace App\Concerns;

trait JobPostValidationRules
{
    protected function jobPostRules(): array
    {
        return [
            'title' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string', 'max:5000'],
            'category' => ['nullable', 'string', 'max:100'],
            'seniority' => ['nullable', 'in:junior,mid,senior,lead'],
            'contract_type' => ['nullable', 'in:full-time,part-time,contract,internship,freelance'],
            'work_modality' => ['nullable', 'in:on-site,remote,hybrid'],
            'city' => ['nullable', 'string', 'max:100'],
            'province' => ['nullable', 'string', 'max:100'],
            'salary_min' => ['nullable', 'numeric', 'min:0'],
            'salary_max' => ['nullable', 'numeric', 'min:0', 'gte:salary_min'],
            'salary_visible' => ['boolean'],
            'vacancies' => ['required', 'integer', 'min:1', 'max:999'],
            'selectedSkills' => ['array'],
        ];
    }
}
