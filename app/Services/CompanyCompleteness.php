<?php

namespace App\Services;

use App\Models\Company;

class CompanyCompleteness
{
    public function items(Company $company): array
    {
        return [
            [
                'key' => 'logo',
                'label' => 'Logo de empresa',
                'description' => 'Subí el logo para que los candidatos reconozcan tu marca',
                'done' => $company->getFirstMedia('company_logo') !== null,
                'icon' => 'image',
                'anchor' => 'identidad',
            ],
            [
                'key' => 'industry',
                'label' => 'Industria',
                'description' => 'Indicá a qué sector pertenece tu empresa',
                'done' => filled($company->industry),
                'icon' => 'category',
                'anchor' => 'identidad',
            ],
            [
                'key' => 'company_size',
                'label' => 'Tamaño de empresa',
                'description' => 'Cantidad aproximada de empleados',
                'done' => filled($company->company_size),
                'icon' => 'group',
                'anchor' => 'identidad',
            ],
            [
                'key' => 'description',
                'label' => 'Descripción',
                'description' => 'Contá de qué se trata tu empresa y qué la hace especial',
                'done' => filled($company->description),
                'icon' => 'notes',
                'anchor' => 'descripcion',
            ],
            [
                'key' => 'city',
                'label' => 'Ubicación',
                'description' => 'Ciudad y provincia donde opera principalmente',
                'done' => filled($company->city),
                'icon' => 'location_on',
                'anchor' => 'contacto',
            ],
            [
                'key' => 'website',
                'label' => 'Sitio web',
                'description' => 'URL de tu sitio o perfil en LinkedIn',
                'done' => filled($company->website),
                'icon' => 'language',
                'anchor' => 'contacto',
            ],
        ];
    }

    public function percentage(Company $company): int
    {
        $items = $this->items($company);
        $done = count(array_filter($items, fn ($i) => $i['done']));

        return (int) round($done / count($items) * 100);
    }

    public function pending(Company $company): array
    {
        return array_values(array_filter($this->items($company), fn ($i) => ! $i['done']));
    }
}
