<?php

namespace App\Policies;

use App\Constants\StatusConstant;
use App\Models\CashAdvance;
use App\Models\User;
use Database\Seeders\RoleSeeder;
class CashAdvancePolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CashAdvance $cashAdvance): bool
    {
        return ($user->role_id === RoleSeeder::ADMIN_ID || $cashAdvance->status !== StatusConstant::APPROVED);
    }

    public function printPdf(User $user, CashAdvance $cashAdvance): bool
    {
        return ($user->role_id === RoleSeeder::ADMIN_ID || $cashAdvance->status === StatusConstant::APPROVED);
    }
}
