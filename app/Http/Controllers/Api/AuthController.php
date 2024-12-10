<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Register a new user.
     */
    public function register(RegisterRequest $request)
    {
        try {
            $data = $request->validated();
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);
            $token = $user->createToken('auth_token')->plainTextToken;
            $user->assignRole('customer');

            return ApiResponseHelper::success('Registration successful', [
                'user' => $user->name,
                'token' => $token,
            ], 201);
        } catch (\Exception $e) {
            return ApiResponseHelper::error('An error occurred', $e->getMessage(), 500);
        }
    }

    /**
     * Authenticate a user.
     */
    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->validated();
            if (!auth()->attempt($credentials)) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            $user = User::where('email', $credentials['email'])->first();
            $token = $user->createToken('auth_token')->plainTextToken;

            return ApiResponseHelper::success('Login successful', [
                'user' => $user->name,
                'role' => $user->getRoleNames()->first(),
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            return ApiResponseHelper::error('An error occurred', $e->getMessage(), 500);
        }
    }

    /**
     * Logout the authenticated user.
     */
    public function logout()
    {
        try {
            Auth::user()->currentAccessToken()->delete();

            return ApiResponseHelper::success('Logout successful', null, 202);
        } catch (\Exception $e) {
            return ApiResponseHelper::error('An error occurred', $e->getMessage(), 500);
        }
    }
}
