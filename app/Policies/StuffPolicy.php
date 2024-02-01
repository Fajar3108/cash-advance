<?php

namespace App\Policies;

use App\Constants\StatusConstant;
use App\Models\Stuff;
use App\Models\User;
use Database\Seeders\RoleSeeder;

class StuffPolicy
{
    public function update(User $user, Stuff $stuff): bool
    {
        return ($user->role_id === RoleSeeder::ADMIN_ID || $stuff->status !== StatusConstant::APPROVED);
    }

    public function printPdf(User $user, Stuff $stuff): bool
    {
        return ($user->role_id === RoleSeeder::ADMIN_ID || $stuff->status === StatusConstant::APPROVED);
    }
}
