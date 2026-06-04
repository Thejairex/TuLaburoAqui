<?php

namespace App\Livewire\Applications;

use App\Models\JobApplication;
use App\Services\JobApplicationService;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Mis postulaciones')]
class Index extends Component
{
    public function withdraw(string $applicationId): void
    {
        $application = JobApplication::forCandidate(Auth::id())
            ->findOrFail($applicationId);

        if ($application->status === 'withdrawn') {
            return;
        }

        app(JobApplicationService::class)->changeStatus($application, 'withdrawn');

        Flux::toast(text: 'Postulación retirada.');
    }

    public function render()
    {
        $applications = JobApplication::forCandidate(Auth::id())
            ->with(['jobPost.company', 'conversation'])
            ->latest()
            ->get();

        return view('livewire.applications.index', compact('applications'));
    }
}
