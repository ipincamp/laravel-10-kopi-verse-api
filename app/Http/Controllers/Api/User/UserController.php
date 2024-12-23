<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateDetailUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    // get all users
    public function index()
    {
        try {
            $users = User::withoutRole('admin')->get();

            if ($users->isEmpty()) {
                abort(404, 'No user found');
            }

            return ApiResponse::send(
                200,
                'Users fetched successfully',
                UserResource::collection($users),
            );
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    // get single user
    public function show(User $user)
    {
        try {
            return ApiResponse::send(
                200,
                'User fetched successfully',
                new UserResource($user),
            );
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    // create new user
    public function store(CreateUserRequest $request)
    {
        try {
            $data = $request->validated();
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);
            $user->assignRole($data('role'));

            return ApiResponse::send(
                201,
                'User created successfully',
                new UserResource($user),
            );
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    // update user
    public function update(UpdateDetailUserRequest $request, User $user)
    {
        try {
            $data = $request->validated();
            $user->update([
                'name' => $data['name'],
                'email' => $data['email'],
            ]);

            return ApiResponse::send(
                200,
                'User updated successfully',
                new UserResource($user),
            );
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }
}
