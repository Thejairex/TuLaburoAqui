<?php

namespace App\Models;

use App\Services\CompanyCompleteness;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[Fillable([
    'legal_name', 'display_name', 'slug', 'tax_id_hash', 'industry', 'company_size',
    'website', 'email', 'phone', 'city', 'province', 'description',
    'avg_rating', 'ratings_count', 'status', 'is_profile_complete',
])]
class Company extends Model implements HasMedia
{
    use HasUuids, InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('company_logo')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function members()
    {
        return $this->hasMany(CompanyMember::class);
    }

    public function owner()
    {
        return $this->hasOne(CompanyMember::class)->where('is_owner', true);
    }

    public function jobPosts()
    {
        return $this->hasMany(JobPost::class);
    }

    public function logoUrl(): ?string
    {
        return $this->getFirstMediaUrl('company_logo') ?: null;
    }

    public function calculateCompleteness(): int
    {
        return app(CompanyCompleteness::class)->percentage($this);
    }

    public function ratingBadge(): string
    {
        if ($this->ratings_count > 0 && $this->avg_rating) {
            return number_format($this->avg_rating, 1).' ★';
        }

        return '';
    }

    public static function generateUniqueSlug(string $name, ?string $excludeId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 1;

        while (
            static::where('slug', $slug)
                ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
                ->exists()
        ) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
