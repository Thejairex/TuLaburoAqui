<?php

namespace App\Livewire\Company;

use App\Concerns\CompanyValidationRules;
use App\Models\Company;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.profile')]
#[Title('Perfil de empresa')]
class Edit extends Component
{
    use CompanyValidationRules, WithFileUploads;

    public string $display_name = '';

    public string $legal_name = '';

    public string $industry = '';

    public string $company_size = '';

    public string $website = '';

    public string $email = '';

    public string $phone = '';

    public string $city = '';

    public string $province = '';

    public string $description = '';

    public $logo = null;

    private ?Company $company = null;

    public function mount(): void
    {
        $company = Auth::user()->companyMemberships()->with('company')->first()?->company;

        if (! $company) {
            session()->flash('error', 'No tenés empresa asociada.');
            $this->redirect(route('dashboard'), navigate: true);

            return;
        }

        $this->company = $company;

        $this->display_name = $company->display_name ?? '';
        $this->legal_name = $company->legal_name ?? '';
        $this->industry = $company->industry ?? '';
        $this->company_size = $company->company_size ?? '';
        $this->website = $company->website ?? '';
        $this->email = $company->email ?? '';
        $this->phone = $company->phone ?? '';
        $this->city = $company->city ?? '';
        $this->province = $company->province ?? '';
        $this->description = $company->description ?? '';
    }

    public function save(): void
    {
        $validated = $this->validate($this->companyRules());

        $company = Auth::user()->companyMemberships()->with('company')->first()?->company;

        if (! $company) {
            return;
        }

        $nameChanged = $validated['display_name'] !== $company->display_name;

        $company->fill([
            'display_name' => $validated['display_name'],
            'legal_name' => $validated['legal_name'],
            'industry' => $validated['industry'] ?? null,
            'company_size' => $validated['company_size'] ?? null,
            'website' => $validated['website'] ?? null,
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'city' => $validated['city'] ?? null,
            'province' => $validated['province'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);

        if ($nameChanged) {
            $company->slug = Company::generateUniqueSlug($validated['display_name'], $company->id);
        }

        $company->save();

        if ($this->logo) {
            $company->addMedia($this->logo->getRealPath())
                ->usingFileName($this->logo->getClientOriginalName())
                ->toMediaCollection('company_logo');
            $this->logo = null;
        }

        $company->is_profile_complete = $company->calculateCompleteness() >= 70;
        $company->save();

        Flux::toast(variant: 'success', text: __('Perfil de empresa actualizado.'));
    }

    public function deleteLogo(): void
    {
        $company = Auth::user()->companyMemberships()->with('company')->first()?->company;
        $company?->clearMediaCollection('company_logo');
        Flux::toast(text: __('Logo eliminado.'));
    }

    public function render()
    {
        $company = Auth::user()->companyMemberships()->with('company')->first()?->company;
        $completeness = $company?->calculateCompleteness() ?? 0;

        return view('livewire.company.edit', compact('company', 'completeness'));
    }
}
