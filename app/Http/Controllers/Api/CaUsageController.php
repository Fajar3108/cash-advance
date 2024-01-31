<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CaUsage;
use App\Models\User;

class CaUsageController extends Controller
{
    public function getByUserId(User $user)
    {
        $caUsages = CaUsage::where('user_id', $user->id)->where('is_approved', '!=', 1)->get();
        return response()->json([
            'message' => "Get user's ca usages",
            'data' => $caUsages->pluck('id'),
        ]);
    }
}
