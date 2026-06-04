<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class Register extends Component
{
    public int $step = 1;

    public string $role = '';

    public function mount(): void
    {
        // Tras un redirect-back por validación fallida (form POST tradicional),
        // restaurar el paso 2 con el rol elegido para que se rendericen los @error.
        $oldRole = old('role');

        if (is_string($oldRole) && in_array($oldRole, ['candidate', 'employer'], true)) {
            $this->role = $oldRole;
            $this->step = 2;
        }
    }

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
