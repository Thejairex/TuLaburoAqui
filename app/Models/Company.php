<?php

namespace App\Models;

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

    public function logoUrl(): ?string
    {
        return $this->getFirstMediaUrl('company_logo') ?: null;
    }

    public function calculateCompleteness(): int
    {
        $fields = [
            filled($this->display_name ?? $this->legal_name),
            filled($this->industry),
            filled($this->company_size),
            filled($this->description),
            filled($this->city),
            filled($this->website),
            $this->getFirstMedia('company_logo') !== null,
        ];

        $filled = count(array_filter($fields));

        return (int) round(($filled / count($fields)) * 100);
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
