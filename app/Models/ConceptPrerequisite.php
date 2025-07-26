<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConceptPrerequisite extends Model
{
    use SoftDeletes;

    protected $table = 'concept_prerequisites';

    protected $fillable = ['concept_id', 'prerequisite_concept_id'];
}

