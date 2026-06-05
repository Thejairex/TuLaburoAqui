<?php

namespace App\Livewire\Admin\Companies;

use App\Models\Company;
use Flux\Flux;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Empresas')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $statusFilter = '';

    public function toggleStatus(string $companyId): void
    {
        $company = Company::findOrFail($companyId);

        $company->update([
            'status' => $company->status === 'blocked' ? 'active' : 'blocked',
        ]);

        Flux::toast(text: 'Estado de la empresa actualizado.');
    }

    public function render()
    {
        $companies = Company::query()
            ->withCount('jobPosts')
            ->when($this->search, fn ($q) => $q->where(function ($q) {
                $q->where('legal_name', 'like', "%{$this->search}%")
                    ->orWhere('display_name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            }))
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->latest()
            ->paginate(20);

        return view('livewire.admin.companies.index', compact('companies'));
    }
}
