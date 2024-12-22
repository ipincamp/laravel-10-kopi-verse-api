<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Determine whether the user can view own/all orders.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('cashier') || $user->hasRole('customer');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Order $order): bool
    {
        if ($user->id === $order->user_id) {
            return true;
        }
        if ($user->hasRole('cashier')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->hasRole('customer')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        if ($user->hasRole('cashier')) {
            return true;
        }
        return false;
    }
}
