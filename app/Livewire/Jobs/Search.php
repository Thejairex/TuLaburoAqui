<?php

namespace App\Livewire\Jobs;

use App\Models\JobPost;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.public')]
#[Title('Buscar ofertas')]
class Search extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $keyword = '';

    #[Url(as: 'lugar')]
    public string $city = '';

    #[Url(as: 'salario')]
    public ?int $salaryMin = null;

    /** @var array<int, string> */
    #[Url(as: 'contrato')]
    public array $contractTypes = [];

    /** @var array<int, string> */
    #[Url(as: 'modalidad')]
    public array $modalities = [];

    /** @var array<int, string> */
    #[Url(as: 'nivel')]
    public array $seniorities = [];

    #[Url(as: 'orden')]
    public string $sort = 'recent';

    public function updated(string $property): void
    {
        if ($property !== 'page') {
            $this->resetPage();
        }
    }

    public function clearFilters(): void
    {
        $this->reset(['keyword', 'city', 'salaryMin', 'contractTypes', 'modalities', 'seniorities', 'sort']);
        $this->sort = 'recent';
        $this->resetPage();
    }

    public function render()
    {
        $jobs = JobPost::query()
            ->published()
            ->with('company')
            ->when($this->keyword !== '', function (Builder $q) {
                $term = '%'.$this->keyword.'%';
                $q->where(function (Builder $sub) use ($term) {
                    $sub->where('title', 'like', $term)
                        ->orWhere('description', 'like', $term)
                        ->orWhere('category', 'like', $term);
                });
            })
            ->when($this->city !== '', fn (Builder $q) => $q->where('city', 'like', '%'.$this->city.'%'))
            ->when($this->salaryMin, fn (Builder $q) => $q->where(function (Builder $sub) {
                $sub->where('salary_max', '>=', $this->salaryMin)
                    ->orWhere('salary_min', '>=', $this->salaryMin);
            }))
            ->when($this->contractTypes, fn (Builder $q) => $q->whereIn('contract_type', $this->contractTypes))
            ->when($this->modalities, fn (Builder $q) => $q->whereIn('work_modality', $this->modalities))
            ->when($this->seniorities, fn (Builder $q) => $q->whereIn('seniority', $this->seniorities))
            ->when(
                $this->sort === 'salary',
                fn (Builder $q) => $q->orderByDesc('salary_max'),
                fn (Builder $q) => $q->latest('published_at'),
            )
            ->paginate(8);

        return view('livewire.jobs.search', compact('jobs'));
    }
}
