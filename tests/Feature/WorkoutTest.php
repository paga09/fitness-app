<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class WorkoutTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetWorkout()
    {
        $date = date("Y-m-d");

        $this->json('GET', '/api/workout/workouts', ["date" => $date])
            ->assertStatus(401);

        Sanctum::actingAs(
            User::where("id", 1)->get()->first()
        );

        $expectedResponse = [[
            'workoutId' => 2,
            'exercises' => [
                [
                    'id' => 2,
                    'name' => 'ex2',
                    'set' => '2',
                    'repetitions' => '2',
                    'weight' => '2',
                    'workout_id' => '2',
                ]],
        ]];

        $this->json('GET', '/api/workout/workouts', ["date" => $date])
            ->assertStatus(200)
            ->assertJson($expectedResponse);
    }

    public function testCreateWorkout()
    {
        $date = date("Y-m-d");

        $this->json('POST', '/api/workout/create_workout', ["date" => $date])
            ->assertStatus(401);

        Sanctum::actingAs(
            User::where("id", 1)->get()->first()
        );

        $expectedResponse = [
            'user_id' => 1,
            'date' => $date
        ];

        $this->json('POST', '/api/workout/create_workout', ["date" => $date])
            ->assertStatus(201)
            ->assertJson($expectedResponse);
    }

    public function testDeleteWorkout()
    {
        $workoutId = 1;
        $this->json('DELETE', '/api/workout/delete_workout', ["workoutId" => $workoutId])
            ->assertStatus(401);

        Sanctum::actingAs(
            User::where("id", 2)->get()->first()
        );

        $this->json('DELETE', '/api/workout/delete_workout', ["workoutId" => $workoutId])
            ->assertStatus(404)
            ->assertJson(['message' => 'Nothing to delete.']);

        Sanctum::actingAs(
            User::where("id", 1)->get()->first()
        );

        $this->json('DELETE', '/api/workout/delete_workout', ["workoutId" => $workoutId])
            ->assertStatus(200);
    }

    public function testCreateExercise()
    {
        $workoutId = 1;

        $this->json('POST', '/api/exercise/create_exercise', ["workoutId" => $workoutId])
            ->assertStatus(401);

        Sanctum::actingAs(
            User::where("id", "2")->get()->first()
        );

        $this->json('POST', '/api/exercise/create_exercise', ["workoutId" => $workoutId])
            ->assertStatus(409);

        Sanctum::actingAs(
            User::where("id", "1")->get()->first()
        );

        $this->json('POST', '/api/exercise/create_exercise', ["workoutId" => $workoutId])
            ->assertStatus(201)
            ->assertJson([
                'name' => 'new exercise',
                'set' => 0,
                'repetitions' => 0,
                'weight' => 0,
                ]);
    }

    public function testDeleteExercise()
    {
        $workoutId = 1;
        $exerciseId = 1;
        $this->json('DELETE', '/api/exercise/delete_exercise', ["workoutId" => $workoutId, "exerciseId" => $exerciseId])
            ->assertStatus(401);

        Sanctum::actingAs(
            User::where("id", 2)->get()->first()
        );

        $this->json('DELETE', '/api/exercise/delete_exercise', ["workoutId" => $workoutId, "exerciseId" => $exerciseId])
            ->assertStatus(404)
            ->assertJson(['message' => 'Nothing to delete.']);

        Sanctum::actingAs(
            User::where("id", 1)->get()->first()
        );

        $this->json('DELETE', '/api/exercise/delete_exercise', ["workoutId" => $workoutId, "exerciseId" => $exerciseId])
            ->assertStatus(200);
    }

    public function testEditExercise()
    {
        $workoutId = 1;
        $exerciseId = 1;
        $data = [
            'workoutId' => $workoutId,
            'exerciseId' => $exerciseId,
            'exerciseName' => 'editedExercise1',
            'exerciseSet' => 10,
            'exerciseRep' => 10,
            'exerciseWeight' => 10,
        ];

        $this->json('PUT', '/api/exercise/edit_exercise', $data)
            ->assertStatus(401);

        Sanctum::actingAs(
            User::where("id", 2)->get()->first()
        );

        $this->json('PUT', '/api/exercise/edit_exercise', $data)
            ->assertStatus(409)
            ->assertJson(['message' => 'Invalid data.']);

        Sanctum::actingAs(
            User::where("id", 1)->get()->first()
        );

        $this->json('PUT', '/api/exercise/edit_exercise', $data)
            ->assertStatus(200);
    }

    public function testGetWorkoutDates()
    {
        $this->json('GET', '/api/workout/workout_dates')
            ->assertStatus(401);

        Sanctum::actingAs(
            User::where("id", 1)->get()->first()
        );

        $this->json('GET', '/api/workout/workout_dates')
            ->assertStatus(200);
    }
    }
