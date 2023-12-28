<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public const ADMIN_ID = '0abd4282-d014-409b-9f0b-e0f020f77693';

    public const USER_ID = 'ba80752f-27bc-43ca-81a0-bb850179312c';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'id' => self::ADMIN_ID,
                'name' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => self::USER_ID,
                'name' => 'User',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Role::insert($roles);
    }
}
