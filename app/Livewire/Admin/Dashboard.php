<?php

namespace App\Livewire\Admin;

use App\Models\Company;
use App\Models\Conversation;
use App\Models\JobApplication;
use App\Models\JobPost;
use App\Models\Review;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Panel de administración')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'totalUsers' => User::count(),
            'candidateCount' => User::where('role', 'candidate')->count(),
            'employerCount' => User::where('role', 'employer')->count(),
            'totalCompanies' => Company::count(),
            'activeCompanies' => Company::where('status', 'active')->count(),
            'totalJobPosts' => JobPost::count(),
            'publishedJobs' => JobPost::published()->count(),
            'totalApplications' => JobApplication::count(),
            'activeConversations' => Conversation::where('status', 'open')->count(),
            'totalReviews' => Review::count(),
            'recentReviews' => Review::with(['reviewer', 'jobApplication.jobPost'])->latest()->take(5)->get(),
            'recentUsers' => User::latest()->take(5)->get(),
        ]);
    }
}
