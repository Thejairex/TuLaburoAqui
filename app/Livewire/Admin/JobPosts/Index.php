<?php

namespace App\Livewire\Admin\JobPosts;

use App\Models\JobPost;
use Flux\Flux;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Ofertas')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $statusFilter = '';

    public function close(string $jobId): void
    {
        $job = JobPost::findOrFail($jobId);
        $job->update(['status' => 'closed']);

        Flux::toast(text: 'Oferta cerrada.');
    }

    public function render()
    {
        $jobs = JobPost::query()
            ->with('company')
            ->withCount('applications')
            ->when($this->search, fn ($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->latest()
            ->paginate(20);

        return view('livewire.admin.job-posts.index', compact('jobs'));
    }
}
