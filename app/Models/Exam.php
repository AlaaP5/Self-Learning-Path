<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Exam extends Model
{
    use SoftDeletes;

    protected $table = 'exams';

    protected $fillable = ['subject_id', 'exam_date', 'is_active'];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
}
