<?php

namespace App\Livewire\Dashboard;

use App\Models\JobApplication;
use App\Models\JobPost;
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

        $publishedCount = $company ? JobPost::forCompany($company->id)->published()->count() : 0;

        $applicationCount = $company
            ? JobApplication::forCompany($company->id)->count()
            : 0;

        $contactedCount = $company
            ? JobApplication::forCompany($company->id)
                ->whereHas('conversation')
                ->count()
            : 0;

        $recentJobs = $company
            ? JobPost::forCompany($company->id)
                ->withCount('applications')
                ->latest()
                ->take(5)
                ->get()
            : collect();

        return view('livewire.dashboard.employer', compact(
            'company', 'percentage', 'items', 'pending', 'publishedCount',
            'applicationCount', 'contactedCount', 'recentJobs'
        ));
    }
}
