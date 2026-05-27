<?php

namespace App\Livewire\Company;

use App\Models\Company;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.public')]
class Show extends Component
{
    public Company $company;

    #[Title('')]
    public function title(): string
    {
        return ($this->company->display_name ?? $this->company->legal_name).' — TuLaburoAquí';
    }

    public function render()
    {
        return view('livewire.company.show');
    }
}
