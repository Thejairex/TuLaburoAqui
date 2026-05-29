<?php

use App\Livewire\Company\Show;
use App\Livewire\Dashboard\Candidate;
use App\Livewire\Dashboard\Employer;
use App\Livewire\Profile\Edit;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::get('empresa/{company}', Show::class)->name('company.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return match (auth()->user()->role) {
            'employer' => redirect()->route('dashboard.employer'),
            default => redirect()->route('dashboard.candidate'),
        };
    })->name('dashboard');

    Route::get('dashboard/candidate', Candidate::class)
        ->middleware('role:candidate')
        ->name('dashboard.candidate');
    Route::get('dashboard/employer', Employer::class)
        ->middleware('role:employer')
        ->name('dashboard.employer');

    Route::get('profile/edit', Edit::class)
        ->middleware('role:candidate')
        ->name('profile.edit.candidate');

    Route::get('company/edit', App\Livewire\Company\Edit::class)
        ->middleware('role:employer')
        ->name('company.edit');
});

require __DIR__.'/settings.php';
