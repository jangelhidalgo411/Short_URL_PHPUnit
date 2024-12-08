<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TestShortener extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_register() {
        $response = $this->postJson('/api/v1/register', [
            'Name' => 'John Doe',
            'Email' => 'JohnDoe@testing.com',
            'Pass' => 'Pass-1234',
            'Pass_Confirm' => 'Pass-1234',
        ]);

        $response->assertStatus(201)
        ->assertJsonStructure([
            'user' => [
                'id', 'name', 'email', 'created_at', 'updated_at'
            ]
        ]);

        $this->assertDatabaseHas('users', [
            'Email' => 'JohnDoe@testing.com',
        ]);
    }

    public function test_user_auth_and_get_token() {
        $user = User::factory()->create([
            'Email' => 'JohnDoe@testing.com',
            'Pass' => bcrypt('Pass-1234'),
        ]);

        $response = $this->postJson('/api/v1/Auth', [
            'Email' => 'JohnDoe@testing.com',
            'Pass' => 'Pass-1234',
        ]);

        $response->assertStatus(200)->assertJsonStructure(['token']);
    }

    public function test_auth_user_get_short_url() {
        $user = User::factory()->create();
        $token = $user->createToken('bear-token')->plainTextToken;

        $response = $this->getJson('/api/v1/short-urls', [
            'Authorization' => 'Bearer ' . $token,
            'url' => 'http://www.example.com'
        ]);

        $response->assertStatus(201)
        ->assertJsonStructure([
            'url' => 'url'
        ]);
    }

}
