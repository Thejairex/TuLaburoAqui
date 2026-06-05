<?php

namespace App\Livewire\Admin\Reviews;

use App\Models\Review;
use Flux\Flux;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Calificaciones')]
class Index extends Component
{
    use WithPagination;

    public string $visibilityFilter = '';

    public function toggleVisibility(string $reviewId): void
    {
        $review = Review::findOrFail($reviewId);

        $review->update([
            'is_visible' => ! $review->is_visible,
        ]);

        Flux::toast(text: 'Visibilidad de la calificación actualizada.');
    }

    public function render()
    {
        $reviews = Review::with(['reviewer', 'reviewed', 'jobApplication.jobPost'])
            ->when($this->visibilityFilter !== '', fn ($q) => $q->where('is_visible', $this->visibilityFilter === 'visible'))
            ->latest()
            ->paginate(20);

        return view('livewire.admin.reviews.index', compact('reviews'));
    }
}
