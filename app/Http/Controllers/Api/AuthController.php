<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function register(UserRequest $request)
    {
        try {

            $role = $request->input('role'); // 'editor' or 'viewer'
            $permission = $role === 'editor' ? 'edit & view' : 'view only';

            $user = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => $role,
                'permission' => $permission,
            ]);

            $user->assignRole($role);


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


    // public function login(Request $request)
    // {
    //     try {
    //         Auth::shouldUse('api');

    //         $credentials = $request->only('username', 'password');

    //         if (!$token = JWTAuth::attempt($credentials)) {
    //             Log::error('JWT attempt failed', ['reason' => 'Invalid credentials or mismatch']);
    //             return response()->json([
    //                 'status' => 401,
    //                 'status_code' => 'error',
    //                 'message' => 'Invalid credentials'
    //             ], 401);
    //         }

    //         return response()->json([
    //             'status' => 200,
    //             'status_code' => 'success',
    //             'message' => 'Login successful',
    //             'data' => [
    //                 'token' => $token,
    //                 'user' => JWTAuth::user()
    //             ]
    //         ], 200);

    //     } catch (\Throwable $e) {
    //         return response()->json([
    //             'status' => 500,
    //             'status_code' => 'error',
    //             'message' => 'Login failed',
    //             'data' => [
    //                 'error' => $e->getMessage()
    //             ]
    //         ], 500);
    //     }
    // }

    public function login(Request $request)
    {
        try {
            Auth::shouldUse('api');

            $credentials = $request->only('username', 'password');

            if (!$token = JWTAuth::attempt($credentials)) {
                Log::error('JWT attempt failed', ['reason' => 'Invalid credentials or mismatch']);
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
                    // 'token' => $token,
                    'user' => JWTAuth::user()
                ]
                // ], 200);
            ])->cookie('token', $token, 60, '/', null, true, true, false, 'None');
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
                // 'data' => auth()->user()
                'data' => JWTAuth::user()
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
            // auth()->logout();
            JWTAuth::invalidate(JWTAuth::getToken());
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

    public function guestAccess()
    {
        // Log::debug('Guest token route triggered');
        // Log::info('Guest token requested');

        $guestUser = User::where('username', 'csd-guest-user')->first();

        if (!$guestUser) {
            // Log::warning('Guest user not found in database');
            return response()->json(['error' => 'Guest user not found'], 404);
        }

        // Log::info('Guest user found, generating token for user ID: ' . $guestUser->id);
        $token = auth('api')->login($guestUser);
        // Log::info('Token generated successfully for guest user');

        return response()->json(['token' => $token]);
    }
}
