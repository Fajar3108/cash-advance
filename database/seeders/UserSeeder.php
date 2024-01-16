<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $signatureImage = public_path('images/sample-signature.png');
        $storagePath = storage_path('app/public/signatures/sample-signature.png');
        File::makeDirectory(storage_path('app/public/signatures'), $mode = 0777, true, true);
        File::copy($signatureImage, $storagePath);
        User::create([
            'id' => 'c56bd349-86f9-4941-9a3e-e568fae81a51',
            'role_id' => RoleSeeder::ADMIN_ID,
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'signature' => 'signature',
            'department' => 'IT Manager',
            'signature' => 'signatures/sample-signature.png',
        ]);
    }
}
