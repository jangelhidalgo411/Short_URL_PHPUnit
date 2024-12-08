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
            'Pass' => bcrypt('Pass-1234'),
        ]);
    
        $response->assertStatus(200)->assertJsonStructure(['token']);
    }

    public function test_auth_user_get_short_url() {
        $response = $this->postJson('/api/v1/Auth', [
            'Email' => 'JohnDoe5@testing.com',
            'Pass' => bcrypt('Pass-1234'),
        ]);

        $user = User::where('email', 'JohnDoe5@testing.com')->first();

        $token = $user->createToken('bear-token')->plainTextToken;

        $response = $this->postJson('/api/v1/short-urls', [
            'Authorization' => 'Bearer ' . $token,
            'url' => 'http://www.example.com'
        ]);

        $response->assertStatus(200)
        ->assertJsonStructure(['url']);
    }

    public function OpenCloseValidation(string $In): bool {
        // Mapa de los cierres válidos
        $pairs = [
            ')' => '(',
            '}' => '{',
            ']' => '[',
        ];

        // array vacio para el balance de los caracteres de apertura
        $Stack = [];

        // Recorremos cada carácter de la cadena
        foreach (str_split($In) as $Char) {
            //Insertamos los caracteres de apertura en un array
            if (in_array($char, ['(', '{', '['])) {
                $Stack[] = $Char;
            }
            //Validamos los de cierre
            elseif (isset($pairs[$char])) {
                // devolvemos falso si no coincide o esta vacio
                //     empty($stack) por si el simbolo de cerrar esta antes que cualquiera de apertura
                //     array_pop($Stack) !== $pairs[$Char el simbolo de cierra tiene que conincidir con el respectivo
                if (empty($stack) || array_pop($Stack) !== $pairs[$Char]) {
                    return false;
                }
            }
        }

        // La pila debe estar vacía si todos los caracteres están balanceados
        return empty($stack);
    }


}
