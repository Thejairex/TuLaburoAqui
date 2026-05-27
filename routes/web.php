<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::get('empresa/{company}', \App\Livewire\Company\Show::class)->name('company.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return match(auth()->user()->role) {
            'employer' => redirect()->route('dashboard.employer'),
            default    => redirect()->route('dashboard.candidate'),
        };
    })->name('dashboard');

    Route::view('dashboard/candidate', 'dashboard.candidate')->name('dashboard.candidate');
    Route::view('dashboard/employer', 'dashboard.employer')->name('dashboard.employer');

    Route::get('profile/edit', \App\Livewire\Profile\Edit::class)
        ->middleware('role:candidate')
        ->name('profile.edit.candidate');

    Route::get('company/edit', \App\Livewire\Company\Edit::class)
        ->middleware('role:employer')
        ->name('company.edit');
});

require __DIR__.'/settings.php';
