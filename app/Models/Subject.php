<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subject extends Model
{
    use SoftDeletes;

    protected $table = 'subjects';

    protected $fillable = ['name', 'grade_id', 'semester'];

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function concepts(): HasMany
    {
        return $this->hasMany(Concept::class);
    }

    public function resources(): HasMany
    {
        return $this->hasMany(Resource::class);
    }

    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }
}

