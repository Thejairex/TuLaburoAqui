<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class Register extends Component
{
    public int $step = 1;

    public string $role = '';

    public function selectRole(string $role): void
    {
        $this->role = $role;
        $this->step = 2;
    }

    public function back(): void
    {
        $this->step = 1;
        $this->role = '';
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
