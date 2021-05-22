<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\WorkoutPlan;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    public function createExercise(Request $request)
    {
        $request->validate([
            "workoutId" => 'required|numeric'
        ]);
        $workoutId = WorkoutPlan::where([["user_id", $request->user()->id], ["id", $request->workoutId]])->get("id");
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

    public function deleteExercise(Request $request)
    {
        $request->validate([
            "workoutId" => 'required|numeric',
            "exerciseId" => 'required|numeric'
        ]);
        $workoutId = WorkoutPlan::where([["user_id", $request->user()->id], ["id", $request->workoutId]])->get("id");
        if (sizeof($workoutId) !== 0) {
            Exercise::where([["id", $request->exerciseId], ["workout_id", $workoutId->first()->id]])->delete();
            return ['message' => 'Exercise deleted.'];
        }
        return response(['message' => 'Nothing to delete.'], 404);
    }

    public function editExercise(Request $request)
    {
        $request->validate([
            'workoutId' => 'required|numeric',
            'exerciseId' => 'required|numeric',
            'exerciseName' => 'required',
            'exerciseSet' => 'required|integer|min:0|max:999',
            'exerciseRep' => 'required|integer|min:0|max:999',
            'exerciseWeight' => 'required|integer|min:0|max:999',
        ]);
        $workoutId = WorkoutPlan::where([["user_id", $request->user()->id], ["id", $request->workoutId]])->get("id");
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
}
