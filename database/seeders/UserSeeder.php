<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id' => 'c56bd349-86f9-4941-9a3e-e568fae81a51',
            'role_id' => RoleSeeder::ADMIN_ID,
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'signature' => 'signature',
        ]);
    }
}
