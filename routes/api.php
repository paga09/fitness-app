<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/authenticated', function () {
    return true;
});

Route::prefix('user')->middleware('auth:sanctum')->group(function () {
    Route::get('/get_user_settings', [Controllers\UserController::class, 'getUserSettings'])->name('get.user.settings');
    Route::post('/edit_user_settings', [Controllers\UserController::class, 'editUserSettings'])->name('edit.user.settings');
});

Route::prefix('workout')->middleware('auth:sanctum')->group(function () {
    Route::get('/workouts', [Controllers\WorkoutController::class, 'workouts'])->name('get.workouts');
    Route::post('/create_workout', [Controllers\WorkoutController::class, 'createWorkout'])->name('create.workout');
    Route::delete('/delete_workout', [Controllers\WorkoutController::class, 'deleteWorkout'])->name('delete.workout');
    Route::get('/workout_dates', [Controllers\WorkoutController::class, 'workoutDates'])->name('get.workout.dates');
});

Route::prefix('exercise')->middleware('auth:sanctum')->group(function () {
    Route::post('/create_exercise', [Controllers\ExerciseController::class, 'createExercise'])->name('create.exercise');
    Route::delete('/delete_exercise', [Controllers\ExerciseController::class, 'deleteExercise'])->name('delete.exercise');
    Route::put('/edit_exercise', [Controllers\ExerciseController::class, 'editExercise'])->name('edit.exercise');
});

Route::prefix('meal')->middleware('auth:sanctum')->group(function () {
    Route::get('/meals', [Controllers\MealController::class, 'meals'])->name('get.meals');
    Route::post('/create_meal', [Controllers\MealController::class, 'createMeal'])->name('create.meal');
    Route::delete('/delete_meal', [Controllers\MealController::class, 'deleteMeal'])->name('delete.meal');
    Route::get('/meal_dates', [Controllers\MealController::class, 'mealDates'])->name('get.meal.dates');
    Route::post('/import_meal', [Controllers\MealController::class, 'importMeal'])->name('import.meal');
});

Route::prefix('food')->middleware('auth:sanctum')->group(function () {
    Route::post('/create_food', [Controllers\FoodController::class, 'createFood'])->name('create.food');
    Route::delete('/delete_food', [Controllers\FoodController::class, 'deleteFood'])->name('delete.food');
    Route::put('/edit_food', [Controllers\FoodController::class, 'editFood'])->name('edit.food');
});

Route::post('register', [Controllers\RegisterController::class, 'register']);
Route::post('login', [Controllers\LoginController::class, 'login']);
Route::post('logout', [Controllers\LoginController::class, 'logout']);