<?php

use App\Livewire\Company\Jobs\Form as JobForm;
use App\Livewire\Company\Jobs\Index as JobIndex;
use App\Livewire\Company\Show;
use App\Livewire\Dashboard\Candidate;
use App\Livewire\Dashboard\Employer;
use App\Livewire\Jobs\Search as JobSearch;
use App\Livewire\Jobs\Show as JobShow;
use App\Livewire\Profile\Edit;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::get('ofertas', JobSearch::class)->name('jobs.search');
Route::get('ofertas/{jobPost}', JobShow::class)->name('jobs.show');

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

    Route::middleware('role:employer')->group(function () {
        Route::get('mis-ofertas', JobIndex::class)->name('company.jobs.index');
        Route::get('mis-ofertas/nueva', JobForm::class)->name('company.jobs.create');
        Route::get('mis-ofertas/{jobPost}/editar', JobForm::class)->name('company.jobs.edit');
    });
});

require __DIR__.'/settings.php';
