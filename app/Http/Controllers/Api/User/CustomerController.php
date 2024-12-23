<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;

class CustomerController extends Controller
{
    // get all user customer
    public function index()
    {
        try {
            $customers = User::role('customer')->get();

            if ($customers->isEmpty()) {
                abort(404, 'No customer found');
            }

            return ApiResponse::send(
                200,
                'Customers fetched successfully',
                UserResource::collection($customers),
            );
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    // get single user customer
    public function show(User $customer)
    {
        try {
            return ApiResponse::send(
                200,
                'Customer fetched successfully',
                new UserResource($customer),
            );
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }
}
