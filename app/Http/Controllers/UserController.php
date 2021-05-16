<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Food;
use App\Models\MealPlan;
use App\Models\User;
use App\Models\WorkoutPlan;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function workouts(Request $request) {

        $request->validate([
            "date" => 'required|date_format:Y-m-d'
        ]);

        $date = $request->date;

        $workouts = WorkoutPlan::where([["user_id", $request->user()->id], ["date", $date]])->get("id");

        $exercises = [];

        foreach ($workouts as $value) {
            $arr = array('workoutId' => $value->id, 'exercises'=> Exercise::where("workout_id", $value->id)->get());
            array_push($exercises, $arr);
        }

        return $exercises;

    }

    public function createWorkout(Request $request) {

        $request->validate([
            "date" => 'required|date_format:Y-m-d'
        ]);

        $date = $request->date;
        $userId = $request->user()->id;

        $workoutPlan = WorkoutPlan::create([
            'user_id' => $userId,
            'date' => $date
        ]);

        return $workoutPlan;

    }

    public function deleteWorkout (Request $request) {

        $request->validate([
            "workoutId" => 'required|numeric'
        ]);

        $workoutId = WorkoutPlan::where([["user_id", $request->user()->id],["id", $request->workoutId]])->get("id");

        if (sizeof($workoutId) !== 0) {
            Exercise::where("workout_id", $workoutId->first()->id)->delete();
            WorkoutPlan::where([["user_id", $request->user()->id], ["id", $request->workoutId]])->delete();
            return ['message' => 'Workout deleted.'];
        }

        return response(['message' => 'Nothing to delete.'], 404);
    }

    public function createExercise(Request $request) {

        $request->validate([
            "workoutId" => 'required|numeric'
        ]);

        $workoutId = WorkoutPlan::where([["user_id", $request->user()->id],["id", $request->workoutId]])->get("id");

        if (sizeof($workoutId) !== 0) {
            $exercise = Exercise::create([
                'name' => 'new exercise',
                'set' => 0,
                'repetitions' => 0,
                'weight' => 0,
                'workout_id' => $workoutId->first()->id,
            ]);
            return $exercise;
        }

        return response('Invalid data.', 409);

    }

    public function deleteExercise(Request $request) {

        $request->validate([
            "workoutId" => 'required|numeric',
            "exerciseId" => 'required|numeric'
        ]);

        $workoutId = WorkoutPlan::where([["user_id", $request->user()->id],["id", $request->workoutId]])->get("id");

        if (sizeof($workoutId) !== 0) {
            Exercise::where([["id", $request->exerciseId],["workout_id", $workoutId->first()->id]])->delete();
            return ['message' => 'Exercise deleted.'];
        }

        return response(['message' => 'Nothing to delete.'], 404);

    }

    public function editExercise(Request $request) {

        $request->validate([
            'workoutId' => 'required|numeric',
            'exerciseId' => 'required|numeric',
            'exerciseName' => 'required',
            'exerciseSet' => 'required|integer|min:0|max:999',
            'exerciseRep' => 'required|integer|min:0|max:999',
            'exerciseWeight' => 'required|integer|min:0|max:999',
        ]);

        $workoutId = WorkoutPlan::where([["user_id", $request->user()->id],["id", $request->workoutId]])->get("id");

        if (sizeof($workoutId) !== 0) {
            $updateDetails = [
                'name' => $request->exerciseName,
                'set' => $request->exerciseSet,
                'repetitions' => $request->exerciseRep,
                'weight' => $request->exerciseWeight,
            ];

            $exercise = Exercise::where([["id", $request->exerciseId], ["workout_id", $workoutId->first()->id]])->update($updateDetails);

            return $exercise;
        }

        return response(['message' => 'Invalid data.'], 409);

    }

    public function workoutDates(Request $request) {

        $workoutDates = WorkoutPlan::where("user_id", $request->user()->id)->get("date");

        return $workoutDates;

    }

    public function meals(Request $request) {

        $request->validate([
            "date" => 'required|date_format:Y-m-d'
        ]);

        $date = $request->date;

        $meals = MealPlan::where([["user_id", $request->user()->id], ["date", $date]])->get();

        $foods = [];

        foreach ($meals as $value) {
            $arr = array('mealId' => $value->uuid, 'foods'=> Food::where("mealplan_id", $value->id)->get());
            array_push($foods, $arr);
        }

        return $foods;

    }


    public function createMeal(Request $request) {

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

    public function deleteMeal (Request $request) {

        $request->validate([
            "mealId" => 'required|uuid'
        ]);

        $mealId = MealPlan::where([["user_id", $request->user()->id],["uuid", $request->mealId]])->get("id");

        if (sizeof($mealId) !== 0) {
            Food::where("mealplan_id", $mealId->first()->id)->delete();
            MealPlan::where([["user_id", $request->user()->id],["uuid", $request->mealId]])->delete();
            return ['message' => 'Meal deleted.'];
        }

        return response(['message' =>  'Nothing to delete.'], 404);
    }

    public function createFood(Request $request) {

        $request->validate([
            "mealId" => 'required|uuid'
        ]);

        $mealId = MealPlan::where([["user_id", $request->user()->id],["uuid", $request->mealId]])->get("id");

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

    public function deleteFood(Request $request) {

        $request->validate([
            "mealId" => 'required|uuid',
            "foodId" => 'required|numeric'
        ]);

        $mealId = MealPlan::where([["user_id", $request->user()->id],["uuid", $request->mealId]])->get("id");

        if (sizeof($mealId) !== 0) {
            Food::where([["id", $request->foodId], ["mealplan_id", $mealId->first()->id]])->delete();
            return ['message' => 'Food deleted.'];
        }

        return response(['message' => 'Nothing to delete.'], 404);

    }

    public function editFood(Request $request) {

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

        $mealId = MealPlan::where([["user_id", $request->user()->id],["uuid", $request->mealId]])->get("id");

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

    public function mealDates(Request $request) {

        $mealDates = MealPlan::where("user_id", $request->user()->id)->get("date");

        return $mealDates;

    }

    public function importMeal(Request $request) {
        $request->validate([
            'mealId' => 'required|uuid',
            'date' => 'required|date_format:Y-m-d'
        ]);

        $mealId = MealPlan::where([["user_id", $request->user()->id], ["uuid", $request->mealId]])->get('id');

        if(sizeof($mealId) == 0) {
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

    public function getUserSettings(Request $request) {

        $userData = User::where('id', $request->user()->id)->get('settings')->first();

        return $userData->settings;
    }

    public function editUserSettings(Request $request) {

        $request->validate([
            'checkedSettings.protein' => 'required|boolean',
            'checkedSettings.carbs' => 'required|boolean',
            'checkedSettings.fat' => 'required|boolean',
            'checkedSettings.fiber' => 'required|boolean',
            'checkedSettings.kcal' => 'required|boolean',
        ]);

        $content = json_decode($request->getContent());

        $updateDetails = [
            "protein" => $content->checkedSettings->protein,
            "carbs" => $content->checkedSettings->carbs,
            "fat" => $content->checkedSettings->fat,
            "fiber" => $content->checkedSettings->fiber,
            "kcal" => $content->checkedSettings->kcal
        ];

        User::where('id', $request->user()->id)->update(['settings' => $updateDetails]);

        return True;

    }

}