<?php

namespace Tests\Feature;

use App\Models\MealPlan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;
use Laravel\Sanctum\Sanctum;


class MealTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetMeals()
    {
        $date = date("Y-m-d");

        $this->json('GET', '/api/meal/meals', ["date" => $date])
            ->assertStatus(401);

        Sanctum::actingAs(
            User::where("id", 1)->get()->first()
        );

        $expectedResponse = [[
            'foods' => [
                [
                    'id' => 2,
                    'name' => 'food2',
                    'quantity' => '200',
                    'protein' => '20.0',
                    'carbohydrates' => '20.0',
                    'fats' => '20.0',
                    'fiber' => '2.0',
                    'kcal' => '340',
                    'mealplan_id' => '2',
                ]],
        ]];

        $this->json('GET', '/api/meal/meals', ["date" => $date])
            ->assertStatus(200)
            ->assertJson($expectedResponse);
    }

    public function testCreateMeal()
    {
        $date = date("Y-m-d");

        $this->json('POST', '/api/meal/create_meal', ["date" => $date])
            ->assertStatus(401);

        Sanctum::actingAs(
            User::where("id", 1)->get()->first()
        );

        $expectedResponse = [
            'user_id' => 1,
            'date' => $date
        ];

        $this->json('POST', '/api/meal/create_meal', ["date" => $date])
            ->assertStatus(201)
            ->assertJson($expectedResponse);
    }

    public function testDeleteMeal()
    {
        $mealId = MealPlan::where('user_id', 1)->first()->uuid;
        $this->json('DELETE', '/api/meal/delete_meal', ["mealId" => $mealId])
            ->assertStatus(401);

        Sanctum::actingAs(
            User::where("id", 2)->get()->first()
        );

        $this->json('DELETE', '/api/meal/delete_meal', ["mealId" => $mealId])
            ->assertStatus(404)
            ->assertJson(['message' => 'Nothing to delete.']);

        Sanctum::actingAs(
            User::where("id", 1)->get()->first()
        );

        $this->json('DELETE', '/api/meal/delete_meal', ["mealId" => $mealId])
            ->assertStatus(200);
    }

    public function testCreateFood()
    {
        $mealId = MealPlan::where('user_id', 1)->first()->uuid;

        $this->json('POST', '/api/food/create_food', ["mealId" => $mealId])
            ->assertStatus(401);

        Sanctum::actingAs(
            User::where("id", "2")->get()->first()
        );

        $this->json('POST', '/api/food/create_food', ["mealId" => $mealId])
            ->assertStatus(409);

        Sanctum::actingAs(
            User::where("id", "1")->get()->first()
        );

        $this->json('POST', '/api/food/create_food', ["mealId" => $mealId])
            ->assertStatus(201)
            ->assertJson([
                'name' => 'new food',
                'quantity' => 0,
                'protein' => 0,
                'carbohydrates' => 0,
                'fats' => 0,
                'fiber' => 0,
                'kcal' => 0,
            ]);
    }

    public function testDeleteFood()
    {
        $mealId = MealPlan::where('user_id', 1)->first()->uuid;
        $foodId = 1;
        $this->json('DELETE', '/api/food/delete_food', ["mealId" => $mealId, "foodId" => $foodId])
            ->assertStatus(401);

        Sanctum::actingAs(
            User::where("id", 2)->get()->first()
        );

        $this->json('DELETE', '/api/food/delete_food', ["mealId" => $mealId, "foodId" => $foodId])
            ->assertStatus(404)
            ->assertJson(['message' => 'Nothing to delete.']);

        Sanctum::actingAs(
            User::where("id", 1)->get()->first()
        );

        $this->json('DELETE', '/api/food/delete_food', ["mealId" => $mealId, "foodId" => $foodId])
            ->assertStatus(200);
    }

    public function testEditFood()
    {
        $mealId = MealPlan::where('user_id', 1)->first()->uuid;
        $foodId = 1;
        $data = [
            'mealId' => $mealId,
            'foodId' => $foodId,
            'foodName' => 'editedFood1',
            'foodQuantity' => 1000,
            'foodProtein' => 100,
            'foodCarbs' => 100,
            'foodFats' => 100,
            'foodFiber' => 10,
            'foodKcal' => 1700,
        ];

        $this->json('PUT', '/api/food/edit_food', $data)
            ->assertStatus(401);

        Sanctum::actingAs(
            User::where("id", 2)->get()->first()
        );

        $this->json('PUT', '/api/food/edit_food', $data)
            ->assertStatus(409)
            ->assertJson(['message' => 'Invalid data.']);

        Sanctum::actingAs(
            User::where("id", 1)->get()->first()
        );

        $this->json('PUT', '/api/food/edit_food', $data)
            ->assertStatus(200);
    }

    public function testGetMealDates()
    {
        $this->json('GET', '/api/meal/meal_dates')
            ->assertStatus(401);

        Sanctum::actingAs(
            User::where("id", 1)->get()->first()
        );

        $this->json('GET', '/api/meal/meal_dates')
            ->assertStatus(200);
    }

    public function testMealImport()
    {
        $mealId = MealPlan::where('user_id', 1)->first()->uuid;
        $date = date("Y-m-d");


        $this->json('POST', '/api/meal/import_meal', ['mealId' => $mealId, 'date' => $date])
            ->assertStatus(401);

        Sanctum::actingAs(
            User::where("id", 2)->get()->first()
        );

        $this->json('POST', '/api/meal/import_meal', ['mealId' => $mealId, 'date' => $date])
            ->assertStatus(409);

        Sanctum::actingAs(
            User::where("id", 1)->get()->first()
        );

        $this->json('POST', '/api/meal/import_meal', ['mealId' => $mealId, 'date' => $date])
            ->assertStatus(201);

    }

}
