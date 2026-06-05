<?php

use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Users\Index;
use App\Livewire\Applications\Index as ApplicationsIndex;
use App\Livewire\Company\Jobs\Applicants as CompanyJobApplicants;
use App\Livewire\Company\Jobs\Form as JobForm;
use App\Livewire\Company\Jobs\Index as JobIndex;
use App\Livewire\Company\Show;
use App\Livewire\Dashboard\Candidate;
use App\Livewire\Dashboard\Employer;
use App\Livewire\Jobs\Search as JobSearch;
use App\Livewire\Jobs\Show as JobShow;
use App\Livewire\Messages\Index as MessagesIndex;
use App\Livewire\Messages\Show as MessagesShow;
use App\Livewire\Profile\Edit;
use App\Models\JobPost;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $featuredJobs = JobPost::query()
        ->published()
        ->with('company')
        ->latest('published_at')
        ->limit(3)
        ->get();

    return view('welcome', compact('featuredJobs'));
})->name('home');

Route::get('ofertas', JobSearch::class)->name('jobs.search');

Route::get('empresa/{company}', Show::class)->name('company.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('ofertas/{jobPost}', JobShow::class)->name('jobs.show');
    Route::get('dashboard', function () {
        return match (auth()->user()->role) {
            'employer' => redirect()->route('dashboard.employer'),
            'admin' => redirect()->route('admin.dashboard'),
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

    Route::get('postulaciones', ApplicationsIndex::class)
        ->middleware('role:candidate')
        ->name('applications.index');

    Route::get('mensajes', MessagesIndex::class)
        ->name('conversations.index');
    Route::get('mensajes/{conversation}', MessagesShow::class)
        ->name('conversations.show');

    Route::middleware('role:employer')->group(function () {
        Route::get('mis-ofertas', JobIndex::class)->name('company.jobs.index');
        Route::get('mis-ofertas/nueva', JobForm::class)->name('company.jobs.create');
        Route::get('mis-ofertas/{jobPost}/editar', JobForm::class)->name('company.jobs.edit');
        Route::get('mis-ofertas/{jobPost}/candidatos', CompanyJobApplicants::class)->name('company.jobs.applicants');
    });

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', Dashboard::class)->name('dashboard');
        Route::get('/usuarios', Index::class)->name('users.index');
        Route::get('/empresas', App\Livewire\Admin\Companies\Index::class)->name('companies.index');
        Route::get('/ofertas', App\Livewire\Admin\JobPosts\Index::class)->name('job-posts.index');
        Route::get('/reviews', App\Livewire\Admin\Reviews\Index::class)->name('reviews.index');
    });
});

require __DIR__.'/settings.php';
