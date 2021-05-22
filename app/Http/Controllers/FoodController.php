<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\MealPlan;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function createFood(Request $request)
    {
        $request->validate([
            "mealId" => 'required|uuid'
        ]);
        $mealId = MealPlan::where([["user_id", $request->user()->id], ["uuid", $request->mealId]])->get("id");
        if (sizeof($mealId) !== 0) {
            $food = Food::create([
                'name' => 'new food',
                'quantity' => 0,
                'protein' => 0,
                'carbohydrates' => 0,
                'fats' => 0,
                'fiber' => 0,
                'kcal' => 0,
                'mealplan_id' => $mealId->first()->id,
            ]);
            return $food;
        }
        return response('Invalid data.', 409);
    }

    public function deleteFood(Request $request)
    {
        $request->validate([
            "mealId" => 'required|uuid',
            "foodId" => 'required|numeric'
        ]);
        $mealId = MealPlan::where([["user_id", $request->user()->id], ["uuid", $request->mealId]])->get("id");
        if (sizeof($mealId) !== 0) {
            Food::where([["id", $request->foodId], ["mealplan_id", $mealId->first()->id]])->delete();
            return ['message' => 'Food deleted.'];
        }
        return response(['message' => 'Nothing to delete.'], 404);
    }

    public function editFood(Request $request)
    {
        $request->validate([
            'mealId' => 'required|uuid',
            'foodId' => 'required|numeric',
            'foodName' => 'required',
            'foodQuantity' => 'required|integer|between:0,9999',
            'foodProtein' => 'required|numeric|between:0,999.9|regex:/^\d+(\.\d{1,1})?$/',
            'foodCarbs' => 'required|numeric|between:0,999.9|regex:/^\d+(\.\d{1,1})?$/',
            'foodFats' => 'required|numeric|between:0,999.9|regex:/^\d+(\.\d{1,1})?$/',
            'foodFiber' => 'required|numeric|between:0,999.9|regex:/^\d+(\.\d{1,1})?$/',
            'foodKcal' => 'required|integer|between:0,9999',
        ]);
        $mealId = MealPlan::where([["user_id", $request->user()->id], ["uuid", $request->mealId]])->get("id");
        if (sizeof($mealId) !== 0) {
            $updateDetails = [
                'name' => $request->foodName,
                'quantity' => $request->foodQuantity,
                'protein' => $request->foodProtein,
                'carbohydrates' => $request->foodCarbs,
                'fats' => $request->foodFats,
                'fiber' => $request->foodFiber,
                'kcal' => $request->foodKcal,
            ];
            $food = Food::where([["id", $request->foodId], ["mealplan_id", $mealId->first()->id]])->update($updateDetails);
            return $food;
        }
        return response(['message' => 'Invalid data.'], 409);
    }
}
