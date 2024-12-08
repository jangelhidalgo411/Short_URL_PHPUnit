<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_register() {
        $response = $this->postJson('/api/v1/register', [
            'Name' => 'John Doe',
            'Email' => 'JohnDoe5@testing.com',
            'Pass' => 'Pass-1234'
        ]);

        $response->assertStatus(201)
        ->assertJsonStructure([
            'user' => [
                'id', 'name', 'email', 'created_at', 'updated_at'
            ]
        ]);

        $this->assertDatabaseHas('users', [
            'Email' => 'JohnDoe5@testing.com',
        ]);
    }

    public function test_user_auth() {
        $response = $this->postJson('/api/v1/Auth', [
            'Email' => 'JohnDoe5@testing.com',
            'Pass' => 'Pass-1234',
        ]);
    
        $response->assertStatus(200)->assertJsonStructure(['token']);
    }

    public function test_auth_user_get_short_url() {
        $response = $this->postJson('/api/v1/Auth', [
            'Email' => 'JohnDoe5@testing.com',
            'Pass' => 'Pass-1234',
        ]);

        $user = User::where('email', 'JohnDoe5@testing.com')->first();

        $token = $user->createToken('bear-token')->plainTextToken;

        $response = $this->postJson('/api/v1/short-urls',
            [
                'url' => 'http://www.example.com'
            ],
            [
                'Authorization' => 'Bearer ' . $token,
            ]
        );

        $response->assertStatus(200)
        ->assertJsonStructure(['url']);
    }
}
