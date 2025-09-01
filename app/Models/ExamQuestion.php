<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Exam extends Model
{
    use SoftDeletes;

    protected $table = 'exam_question';

    protected $fillable = ['exam_id', 'question_id'];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
}
