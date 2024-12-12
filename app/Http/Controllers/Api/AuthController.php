<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
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

            return ApiResponse::send(
                201,
                'Registration successful',
                [
                    'user' => $user->name,
                    'token' => $token,
                ],
            );
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
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
                abort(401, 'Invalid credentials');
            }

            $user = User::where('email', $credentials['email'])->first();
            $token = $user->createToken('auth_token')->plainTextToken;

            return ApiResponse::send(
                200,
                'Login successful',
                [
                    'user' => $user->name,
                    'role' => $user->getRoleNames()->first(),
                    'token' => $token,
                ],
            );
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    /**
     * Logout the authenticated user.
     */
    public function logout()
    {
        try {
            if (!Auth::check()) {
                abort(401, 'Unauthenticated');
            }

            Auth::user()->currentAccessToken()->delete();

            return ApiResponse::send(202, 'Logout successful');
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }
}
