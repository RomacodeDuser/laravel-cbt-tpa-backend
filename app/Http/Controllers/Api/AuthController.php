<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ' required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required'
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' =>$validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' =>'user'
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'user'=>UserResource::make($user),
        ]);

    }
}
