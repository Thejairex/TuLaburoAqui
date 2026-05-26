<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return match(auth()->user()->role) {
            'employer' => redirect()->route('dashboard.employer'),
            default    => redirect()->route('dashboard.candidate'),
        };
    })->name('dashboard');

    Route::view('dashboard/candidate', 'dashboard.candidate')->name('dashboard.candidate');
    Route::view('dashboard/employer', 'dashboard.employer')->name('dashboard.employer');

    Route::livewire('profile/edit', \App\Livewire\Profile\Edit::class)
        ->middleware('role:candidate')
        ->name('profile.edit.candidate');
});

require __DIR__.'/settings.php';
