<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User Admin
        $admin = User::create([
            'name' => config('custom.admin.name'),
            'email' => config('custom.admin.email'),
            'password' => bcrypt(config('custom.admin.password')),
        ]);
        $admin->assignRole('admin');

        // User Cashier
        $cashier = User::create([
            'name' => config('custom.cashier.name'),
            'email' => config('custom.cashier.email'),
            'password' => bcrypt(config('custom.cashier.password')),
        ]);
        $cashier->assignRole('cashier');

        // User Customer
        $customer = User::create([
            'name' => config('custom.customer.name'),
            'email' => config('custom.customer.email'),
            'password' => bcrypt(config('custom.customer.password')),
        ]);
        $customer->assignRole('customer');
    }
}
