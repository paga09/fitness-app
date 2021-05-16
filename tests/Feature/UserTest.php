<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public function testUser()
    {
        $this->json('GET', '/api/user')->assertStatus(401);
        $this->json('GET', '/api/authenticated')->assertStatus(401);

        Sanctum::actingAs(
            User::where("id", 1)->get()->first()
        );

        $this->json('GET', '/api/user')->assertStatus(200);
        $this->json('GET', '/api/authenticated')->assertStatus(200);
    }

    public function testGetUserSettings()
    {
        $this->json('GET', '/api/user/get_user_settings')->assertStatus(401);

        Sanctum::actingAs(
            User::where("id", 1)->get()->first()
        );

        $this->json('GET', '/api/user/get_user_settings')->assertStatus(200);
    }

    public function testEditUserSettings()
    {
        $this->json('POST', '/api/user/edit_user_settings')->assertStatus(401);

        Sanctum::actingAs(
            User::where("id", 1)->get()->first()
        );

        $data = [
            'checkedSettings' => [
                'protein' => false,
                'carbs' => false,
                'fat' => false,
                'fiber' => false,
                'kcal' => false,
            ]
        ];


        $this->json('POST', '/api/user/edit_user_settings', $data)->assertStatus(200);
    }
}
