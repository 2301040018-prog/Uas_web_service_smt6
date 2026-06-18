<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // 1. FITUR REGISTER
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    // 2. FITUR LOGIN (Generate Token)
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $credentials = $request->only('email', 'password');

        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized / Email atau password salah'], 401);
        }

        return $this->createNewToken($token);
    }

    // 3. FITUR LOGOUT (Hapus Token)
    public function logout()
    {
        auth()->guard('api')->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    // 4. FITUR LIHAT PROFIL USER YANG SEDANG LOGIN
    public function me()
    {
        return response()->json(auth()->guard('api')->user());
    }

    // Format Response untuk Token JWT
// Format Response untuk Token JWT
protected function createNewToken($token)
{
    return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        // Mengambil langsung nilai TTL (Time To Live) dari file config jwt
        'expires_in' => config('jwt.ttl') * 60, 
        'user' => auth()->guard('api')->user()
    ]);
}
}