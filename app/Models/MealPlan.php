<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
 * @mixin Builder
 */

class MealPlan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'date', 'uuid'];

    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
           $model->uuid = (string) Str::uuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function food() {
        return $this->hasMany('App\Models\Food');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
