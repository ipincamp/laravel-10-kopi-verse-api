<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\UpdateUserDetailRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class CashierController extends Controller
{
    // get all user cashier
    public function index()
    {
        try {
            $cashiers = User::role('cashier')->get();

            if ($cashiers->isEmpty()) {
                abort(404, 'No cashier found');
            }

            return ApiResponse::send(
                200,
                'Cashiers fetched successfully',
                UserResource::collection($cashiers),
            );
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    // get single user cashier
    public function show(User $cashier)
    {
        try {
            return ApiResponse::send(
                200,
                'Cashier fetched successfully',
                new UserResource($cashier),
            );
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    // create new user cashier
    public function store(RegisterRequest $request)
    {
        try {
            $data = $request->validated();
            $cashier = User::create([
                'name' => $data('name'),
                'email' => $data('email'),
                'password' => bcrypt($data('password')),
            ]);
            $cashier->assignRole('cashier');

            return ApiResponse::send(
                201,
                'Cashier created successfully',
                new UserResource($cashier),
            );
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    // update user cashier
    public function update(UpdateUserDetailRequest $request, User $cashier)
    {
        try {
            $data = $request->validated();
            $cashier->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);

            return ApiResponse::send(
                200,
                'Cashier updated successfully',
                new UserResource($cashier),
            );
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }
}
