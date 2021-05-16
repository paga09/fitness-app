<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\MealPlan;
use App\Models\WorkoutPlan;
use App\Models\Food;
use App\Models\Exercise;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $d=strtotime("yesterday");

        //Users

        User::create([
            'email' => 'user1@email',
            'password' => Hash::make('password'),
            'settings' => '{"protein":true,"carbs":true,"fat":true,"fiber":true,"kcal":true}'
        ]);
        User::create([
            'email' => 'user2@email',
            'password' => Hash::make('password'),
            'settings' => '{"protein":true,"carbs":true,"fat":true,"fiber":true,"kcal":true}'
        ]);

        //Workout Plans

        WorkoutPlan::create([
            'user_id' => 1,
            'date' => date("Y-m-d", $d)
        ]);

        WorkoutPlan::create([
            'user_id' => 1,
            'date' => date("Y-m-d")
        ]);

        //Meal Plans

        MealPlan::create([
            'user_id' => 1,
            'date' => date("Y-m-d", $d)
        ]);

        MealPlan::create([
            'user_id' => 1,
            'date' => date("Y-m-d")
        ]);

        MealPlan::create([
            'user_id' => 2,
            'date' => date("Y-m-d")
        ]);

        //Exercises

        Exercise::create([
            'name' => 'ex1',
            'set' => 1,
            'repetitions' => 1,
            'weight' => 1,
            'workout_id' => 1
        ]);

        Exercise::create([
            'name' => 'ex2',
            'set' => 2,
            'repetitions' => 2,
            'weight' => 2,
            'workout_id' => 2
        ]);

        //Foods

        Food::create([
            'name' => 'food1',
            'quantity' => 100,
            'protein' => 10,
            'carbohydrates' => 10,
            'fats' => 10,
            'fiber' => 1,
            'kcal' => 170,
            'mealplan_id' => 1
        ]);

        Food::create([
            'name' => 'food2',
            'quantity' => 200,
            'protein' => 20,
            'carbohydrates' => 20,
            'fats' => 20,
            'fiber' => 2,
            'kcal' => 340,
            'mealplan_id' => 2
        ]);

        Food::create([
            'name' => 'food3',
            'quantity' => 300,
            'protein' => 30,
            'carbohydrates' => 30,
            'fats' => 30,
            'fiber' => 3,
            'kcal' => 510,
            'mealplan_id' => 3
        ]);

    }
}
