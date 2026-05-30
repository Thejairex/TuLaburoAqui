<?php

namespace App\Livewire\Jobs;

use App\Models\JobPost;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
class Show extends Component
{
    public JobPost $jobPost;

    public function mount(JobPost $jobPost): void
    {
        // Solo se exponen públicamente ofertas publicadas y vigentes.
        abort_unless($jobPost->isPublished(), 404);

        $this->jobPost = $jobPost->load(['company', 'skills']);
    }

    public function title(): string
    {
        return $this->jobPost->title.' — TuLaburoAquí';
    }

    public function render()
    {
        return view('livewire.jobs.show');
    }
}
