<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;

class WorkerSkill extends Pivot
{
    use HasUuids;

    protected $table = 'worker_skills';

    public $incrementing = false;

    protected $keyType = 'string';
}
