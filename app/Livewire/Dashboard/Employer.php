<?php

namespace App\Livewire\Dashboard;

use App\Services\CompanyCompleteness;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Panel de empresa')]
class Employer extends Component
{
    public function render()
    {
        $user = Auth::user()->load('companyMemberships.company');
        $company = $user->companyMemberships->first()?->company;

        $service = app(CompanyCompleteness::class);
        $percentage = $company ? $service->percentage($company) : 0;
        $items = $company ? $service->items($company) : [];
        $pending = $company ? $service->pending($company) : [];

        return view('livewire.dashboard.employer', compact(
            'company', 'percentage', 'items', 'pending'
        ));
    }
}
