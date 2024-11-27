<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
        ]);

        // User Admin
        $admin = User::create([
            'name' => config('custom.admin.name'),
            'email' => config('custom.admin.email'),
            'password' => bcrypt(config('custom.admin.password')),
        ]);
        $admin->assignRole('admin');
    }
}
