<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin Builder
 */

class Food extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'foods';

    protected $fillable = ['name', 'quantity', 'protein', 'carbohydrates', 'fats', 'fiber', 'kcal', 'mealplan_id'];

    public function mealPlan() {
        return $this->belongsTo('App\Models\MealPlan');
    }
}
