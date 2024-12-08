<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;
use Illuminate\Validation\ValidationException;

class ShortenerController extends Controller {
	public function index(Request $r) {
		return view('welcome');
	}

    public function register(Request $r) {
        $r->validate([
            'Name' => 'required|string|max:255',
            'Email' => 'required|string|email|max:255|unique:users',
            'Pass' => [
                'required',
                'min:8'
            ]
        ]);

        $user = User::create([
            'name' => $r->Name,
            'email' => $r->Email,
            'password' => Hash::make($r->Pass),
        ]);

        return response()->json(['user' => $user], 201);
    }

    public function Auth(Request $r) {
        $r->validate([
            'Email' => 'required|email',
            'Pass' => 'required',
        ]);

        $user = User::where('email', $r->Email)->first();

        if (!$user || !Hash::check($r->Pass, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Credentiales incorrectas.'],
            ]);
        }

        $token = $user->createToken('bear-token')->plainTextToken;

        return response()->json(['token' => $token], 200);        
	}

    public function Shortener(Request $r) {
        $r->validate([
            'url' => 'required|string|max:255'
        ]);

        $BearAuth = $r->header('Authorization');

        if (!$BearAuth || !$this->OpenCloseValidation($BearAuth)) {
            return response()->json(['message' => 'No autorizado'], 401);
        }

        $Client = new Client(['verify' => false]);
        $res = $Client->request('GET', 'https://tinyurl.com/api-create.php?url='.$r->url);

        return response()->json(['url' => (string)$res->getBody()], 200);
    }

    public function logout(Request $r) {
        $r->user()->tokens()->delete();

        return response()->json(['message' => 'Session Cerrada'], 200);
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
            if (in_array($Char, ['(', '{', '['])) {
                $Stack[] = $Char;
            }
            //Validamos los de cierre
            elseif (isset($pairs[$Char])) {
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