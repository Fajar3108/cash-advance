<?php

namespace App\Policies;

use App\Constants\StatusConstant;
use App\Models\Reimbursement;
use App\Models\User;
use Database\Seeders\RoleSeeder;

class ReimbursementPolicy
{
    public function update(User $user, Reimbursement $reimbursement): bool
    {
        return ($user->role_id === RoleSeeder::ADMIN_ID || $reimbursement->status !== StatusConstant::APPROVED);
    }

    public function printPdf(User $user, Reimbursement $reimbursement): bool
    {
        return ($user->role_id === RoleSeeder::ADMIN_ID || $reimbursement->status === StatusConstant::APPROVED);
    }
}
