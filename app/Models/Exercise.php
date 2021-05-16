<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin Builder
 */

class Exercise extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'set', 'repetitions', 'weight', 'workout_id'];

    public function workoutPlan() {
        return $this->belongsTo('App\Models\WorkoutPlan');
    }
}
