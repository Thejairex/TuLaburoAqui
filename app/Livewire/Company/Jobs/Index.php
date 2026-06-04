<?php

namespace App\Livewire\Company\Jobs;

use App\Models\JobPost;
use App\Services\JobPostService;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Mis ofertas')]
class Index extends Component
{
    public function changeStatus(string $jobId, string $status): void
    {
        $job = $this->resolveJob($jobId);

        app(JobPostService::class)->changeStatus($job, $status);

        Flux::toast(variant: 'success', text: __('Estado de la oferta actualizado.'));
    }

    public function delete(string $jobId): void
    {
        $job = $this->resolveJob($jobId);
        $job->delete();

        Flux::toast(text: __('Oferta eliminada.'));
    }

    private function resolveJob(string $jobId): JobPost
    {
        $company = $this->company();

        return JobPost::query()
            ->forCompany($company->id)
            ->findOrFail($jobId);
    }

    private function company()
    {
        $company = Auth::user()->companyMemberships()->with('company')->first()?->company;

        abort_unless($company !== null, 403);

        return $company;
    }

    public function render()
    {
        $company = $this->company();

        $jobs = JobPost::query()
            ->forCompany($company->id)
            ->withCount(['skills', 'applications'])
            ->latest()
            ->get();

        return view('livewire.company.jobs.index', compact('jobs'));
    }
}
