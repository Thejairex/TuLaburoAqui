<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

#[Fillable(['legal_name', 'display_name', 'tax_id_hash', 'industry', 'company_size', 'website', 'email', 'phone', 'city', 'province', 'location', 'description', 'avg_rating', 'ratings_count', 'status'])]
#[Hidden([])]
class Company extends Model implements HasMedia
{
    use InteractsWithMedia, HasUuids;


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logos')->singleFile();
    }
}
