<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShortenerController extends Controller {
	public function index(Request $r) {
		return view('welcome');
	}

    public function register(Request $request) {
        $request->validate([
            'Name' => 'required|string|max:255',
            'Email' => 'required|string|email|max:255|unique:users',
            'Pass' => [
                'required',
                'min:8',
                'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
                'confirmed'
            ],
            'Pass_Confirm' => 'required|same:Pass' 
        ]);

        $user = User::create([
            'name' => $r->name,
            'email' => $r->email,
            'password' => Hash::make($r->password),
        ]);

        return response()->json(['user' => $user], 201);
    }

    public function Auth(Request $r) {
        $r->validate([
            'Email' => 'required|email',
            'Pass' => 'required',
        ]);

        $user = User::where('email', $r->email)->first();

        if (!$user || !Hash::check($r->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Credentiales incorrectas.'],
            ]);
        }

        $token = $user->createToken('bear-token')->plainTextToken;

        return response()->json(['token' => $token], 200);        
	}

    public function Shortener(Request $r) {
        return response()->json($request->user());
    }

    public function logout(Request $r) {
        $r->user()->tokens()->delete();

        return response()->json(['message' => 'Session Cerrada'], 200);
    }
}