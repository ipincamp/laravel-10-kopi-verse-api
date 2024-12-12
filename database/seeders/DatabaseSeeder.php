<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // permission & role
        collect(['customer', 'cashier', 'admin'])->each(fn($role) => Role::create(['name' => $role]));

        // user
        $roles = ['admin', 'cashier', 'customer'];
        foreach ($roles as $role) {
            $user = User::create([
                'name' => config("custom.$role.name"),
                'email' => config("custom.$role.email"),
                'password' => bcrypt(config("custom.$role.password")),
            ]);
            // assign role
            $user->assignRole($role);
            // create cart
            $user->cart()->create();
        }

        // product
        Product::factory(10)->create();
    }
}
