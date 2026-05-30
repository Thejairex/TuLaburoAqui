<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;

class JobPostSkill extends Pivot
{
    use HasUuids;

    protected $table = 'job_post_skills';

    public $incrementing = false;

    protected $keyType = 'string';
}
