<?php

namespace App\Concerns;

trait CompanyValidationRules
{
    protected function companyRules(): array
    {
        return [
            'display_name' => ['required', 'string', 'max:255'],
            'legal_name'   => ['required', 'string', 'max:255'],
            'industry'     => ['nullable', 'string', 'max:100'],
            'company_size' => ['nullable', 'string', 'max:50'],
            'website'      => ['nullable', 'url', 'max:255'],
            'email'        => ['nullable', 'email', 'max:255'],
            'phone'        => ['nullable', 'string', 'max:30'],
            'city'         => ['nullable', 'string', 'max:100'],
            'province'     => ['nullable', 'string', 'max:100'],
            'description'  => ['nullable', 'string', 'max:2000'],
            'logo'         => ['nullable', 'image', 'max:2048'],
        ];
    }
}
