<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->is_admin) { // Assuming 'is_admin' column exists
                $token = $user->createToken('admin-token')->plainTextToken;

                return response()->json([
                    'token' => $token,
                    'user' => $user,
                ], 200);
            } else {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }
}
