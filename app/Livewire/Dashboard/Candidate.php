<?php

namespace App\Livewire\Dashboard;

use App\Services\WorkerProfileCompleteness;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Mi espacio')]
class Candidate extends Component
{
    public function render()
    {
        $user = Auth::user()->load('workerProfile.skills');
        $service = app(WorkerProfileCompleteness::class);

        $profile = $user->workerProfile;
        $percentage = $service->percentage($user);
        $items = $service->items($user);
        $pending = $service->pending($user);

        $summary = [
            'avatar_url' => $user->avatarUrl(),
            'initials' => $user->initials(),
            'name' => $user->name,
            'headline' => $profile?->headline,
            'city' => $profile?->city,
            'province' => $profile?->province,
            'skills_count' => $profile?->skills->count() ?? 0,
            'has_cv' => $profile?->getFirstMedia('cv') !== null,
        ];

        return view('livewire.dashboard.candidate', compact(
            'summary', 'percentage', 'items', 'pending'
        ));
    }
}
