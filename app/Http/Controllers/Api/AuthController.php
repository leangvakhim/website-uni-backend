<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(UserRequest $request)
    {
        try {
            $user = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);
    
            $user->assignRole('editor'); 
    
            return response()->json([
                'status' => 201,
                'status_code' => 'success',
                'message' => 'User registered successfully',
            ], 201);
    
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 500,
                'status_code' => 'error',
                'message' => 'Register failed',
                'data' => [
                    'error' => $e->getMessage()
                ]
            ], 500);
        }
    }
    

    public function login(Request $request)
    {
        try {
            $credentials = $request->only('username', 'password');

            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => 401,
                    'status_code' => 'error',
                    'message' => 'Invalid credentials'
                ], 401);
            }

            return response()->json([
                'status' => 200,
                'status_code' => 'success',
                'message' => 'Login successful',
                'data' => [
                    'token' => $token,
                    'user' => auth()->user()
                ]
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'status' => 500,
                'status_code' => 'error',
                'message' => 'Login failed',
                'data' => [
                    'error' => $e->getMessage()
                ]
            ], 500);
        }
    }

    public function me()
    {
        try {
            return response()->json([
                'status' => 200,
                'status_code' => 'success',
                'message' => 'Authenticated user',
                'data' => auth()->user()
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 500,
                'status_code' => 'error',
                'message' => 'Fetch failed',
                'data' => [
                    'error' => $e->getMessage()
                ]
            ]);
        }
    }

    public function logout()
    {
        try {
            auth()->logout();
            return response()->json([
                'status' => 200,
                'status_code' => 'success',
                'message' => 'Logged out successfully'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 500,
                'status_code' => 'error',
                'message' => 'Logout failed',
                'data' => [
                    'error' => $e->getMessage()
                ]
            ]);
        }
    }
}
