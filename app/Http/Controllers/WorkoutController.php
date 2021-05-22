<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\WorkoutPlan;
use Illuminate\Http\Request;

class WorkoutController extends Controller
{
    public function workouts(Request $request)
    {
        $request->validate([
            "date" => 'required|date_format:Y-m-d'
        ]);
        $date = $request->date;
        $workouts = WorkoutPlan::where([["user_id", $request->user()->id], ["date", $date]])->get("id");
        $exercises = [];
        foreach ($workouts as $value) {
            $arr = array('workoutId' => $value->id, 'exercises' => Exercise::where("workout_id", $value->id)->get());
            array_push($exercises, $arr);
        }
        return $exercises;
    }

    public function createWorkout(Request $request)
    {
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

    public function deleteWorkout(Request $request)
    {
        $request->validate([
            "workoutId" => 'required|numeric'
        ]);
        $workoutId = WorkoutPlan::where([["user_id", $request->user()->id], ["id", $request->workoutId]])->get("id");
        if (sizeof($workoutId) !== 0) {
            Exercise::where("workout_id", $workoutId->first()->id)->delete();
            WorkoutPlan::where([["user_id", $request->user()->id], ["id", $request->workoutId]])->delete();
            return ['message' => 'Workout deleted.'];
        }
        return response(['message' => 'Nothing to delete.'], 404);
    }

    public function workoutDates(Request $request)
    {
        $workoutDates = WorkoutPlan::where("user_id", $request->user()->id)->get("date");
        return $workoutDates;
    }
}
