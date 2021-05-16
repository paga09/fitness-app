<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin Builder
 */

class WorkoutPlan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'date'];

    public function exercise() {
        return $this->hasMany('App\Models\Exercise');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
