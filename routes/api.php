<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/user/workouts', [App\Http\Controllers\UserController::class, 'workouts']);

Route::middleware('auth:sanctum')->post('/user/create_workout', [App\Http\Controllers\UserController::class, 'createWorkout']);

Route::middleware('auth:sanctum')->delete('/user/delete_workout', [App\Http\Controllers\UserController::class, 'deleteWorkout']);

Route::middleware('auth:sanctum')->post('/user/create_exercise', [App\Http\Controllers\UserController::class, 'createExercise']);

Route::middleware('auth:sanctum')->delete('/user/delete_exercise', [App\Http\Controllers\UserController::class, 'deleteExercise']);

Route::middleware('auth:sanctum')->put('/user/edit_exercise', [App\Http\Controllers\UserController::class, 'editExercise']);

Route::middleware('auth:sanctum')->get('/user/workout_dates', [App\Http\Controllers\UserController::class, 'workoutDates']);



Route::middleware('auth:sanctum')->get('/user/meals', [App\Http\Controllers\UserController::class, 'meals']);

Route::middleware('auth:sanctum')->post('/user/create_meal', [App\Http\Controllers\UserController::class, 'createMeal']);

Route::middleware('auth:sanctum')->delete('/user/delete_meal', [App\Http\Controllers\UserController::class, 'deleteMeal']);

Route::middleware('auth:sanctum')->post('/user/create_food', [App\Http\Controllers\UserController::class, 'createFood']);

Route::middleware('auth:sanctum')->delete('/user/delete_food', [App\Http\Controllers\UserController::class, 'deleteFood']);

Route::middleware('auth:sanctum')->put('/user/edit_food', [App\Http\Controllers\UserController::class, 'editFood']);

Route::middleware('auth:sanctum')->get('/user/meal_dates', [App\Http\Controllers\UserController::class, 'mealDates']);

Route::middleware('auth:sanctum')->post('/user/import_meal', [App\Http\Controllers\UserController::class, 'importMeal']);



Route::middleware('auth:sanctum')->get('/user/get_user_settings', [App\Http\Controllers\UserController::class, 'getUserSettings']);

Route::middleware('auth:sanctum')->post('/user/edit_user_settings', [App\Http\Controllers\UserController::class, 'editUserSettings']);


Route::middleware('auth:sanctum')->get('/authenticated', function () {
    return true;
});

Route::post('register', [App\Http\Controllers\RegisterController::class, 'register']);
Route::post('login', [App\Http\Controllers\LoginController::class, 'login']);
Route::post('logout', [App\Http\Controllers\LoginController::class, 'logout']);