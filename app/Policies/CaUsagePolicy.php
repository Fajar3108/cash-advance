<?php

namespace App\Policies;

use App\Constants\StatusConstant;
use App\Models\CaUsage;
use App\Models\User;
use Database\Seeders\RoleSeeder;

class CaUsagePolicy
{
    public function update(User $user, CaUsage $caUsage): bool
    {
        return ($user->role_id === RoleSeeder::ADMIN_ID || $caUsage->status !== StatusConstant::APPROVED);
    }

    public function printPdf(User $user, CaUsage $caUsage): bool
    {
        return ($user->role_id === RoleSeeder::ADMIN_ID || $caUsage->status === StatusConstant::APPROVED);
    }
}
