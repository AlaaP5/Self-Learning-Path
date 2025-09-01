<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resource extends Model
{
    use SoftDeletes;

    protected $table = 'resources';

    protected $fillable = ['subject_id', 'title', 'type', 'url'];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
}

