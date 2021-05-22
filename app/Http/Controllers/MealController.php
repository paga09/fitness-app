<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\MealPlan;
use Illuminate\Http\Request;

class MealController extends Controller
{
    public function meals(Request $request)
    {
        $request->validate([
            "date" => 'required|date_format:Y-m-d'
        ]);
        $date = $request->date;
        $meals = MealPlan::where([["user_id", $request->user()->id], ["date", $date]])->get();
        $foods = [];
        foreach ($meals as $value) {
            $arr = array('mealId' => $value->uuid, 'foods' => Food::where("mealplan_id", $value->id)->get());
            array_push($foods, $arr);
        }
        return $foods;
    }

    public function createMeal(Request $request)
    {
        $request->validate([
            "date" => 'required|date_format:Y-m-d'
        ]);
        $date = $request->date;
        $userId = $request->user()->id;

        $mealPlan = Mealplan::create([
            'user_id' => $userId,
            'date' => $date
        ]);
        return $mealPlan;
    }

    public function deleteMeal(Request $request)
    {
        $request->validate([
            "mealId" => 'required|uuid'
        ]);
        $mealId = MealPlan::where([["user_id", $request->user()->id], ["uuid", $request->mealId]])->get("id");
        if (sizeof($mealId) !== 0) {
            Food::where("mealplan_id", $mealId->first()->id)->delete();
            MealPlan::where([["user_id", $request->user()->id], ["uuid", $request->mealId]])->delete();
            return ['message' => 'Meal deleted.'];
        }
        return response(['message' => 'Nothing to delete.'], 404);
    }

    public function mealDates(Request $request)
    {
        $mealDates = MealPlan::where("user_id", $request->user()->id)->get("date");
        return $mealDates;
    }

    public function importMeal(Request $request)
    {
        $request->validate([
            'mealId' => 'required|uuid',
            'date' => 'required|date_format:Y-m-d'
        ]);
        $mealId = MealPlan::where([["user_id", $request->user()->id], ["uuid", $request->mealId]])->get('id');
        if (sizeof($mealId) == 0) {
            return response(['message' => 'Invalid data.'], 409);
        }
        $newMeal = Mealplan::create([
            'user_id' => $request->user()->id,
            'date' => $request->date
        ]);
        $foods = Food::where("mealplan_id", $mealId->first()->id)->get();
        foreach ($foods as &$food) {
            Food::create([
                'name' => $food->name,
                'quantity' => $food->quantity,
                'protein' => $food->protein,
                'carbohydrates' => $food->carbohydrates,
                'fats' => $food->fats,
                'fiber' => $food->fiber,
                'kcal' => $food->kcal,
                'mealplan_id' => $newMeal->id,
            ]);
        }
        return $newMeal;
    }
}
