<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $email = $request->input('email');
        $password = Hash::make($request->input('password'));

        $user = User::create([
            'email' => $email,
            'password' => $password
        ]);

        $access_token = JWT::encode($user->toArray(), 'secret', 'HS256');

        return response()->json([
            'access_token' => $access_token,
            'user' => $user
        ]);
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();
        if ($user == null) {
            return response()->json([
                'message' => "User tidak ditemukan"
            ], 400);
        }

        $is_password_confirmed = Hash::check($password, $user->password);
        if (!$is_password_confirmed) {
            return response()->json([
                'message' => "Password Salah"
            ], 400);
        }

        $access_token = JWT::encode($user->toArray(), 'secret', 'HS256');

        return response()->json([
            'access_token' => $access_token,
            'user' => $user
        ]);
    }
}
