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

        if (null == $r->bearerToken()) {
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
}