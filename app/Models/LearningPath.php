<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LearningPath extends Model
{
    use SoftDeletes;

    protected $table = 'learning_paths';

    protected $fillable = ['student_id', 'exam_id', 'concept_id', 'recommended_order', 'is_completed'];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function concept(): BelongsTo
    {
        return $this->belongsTo(Concept::class);
    }
}

