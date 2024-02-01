<?php

namespace App\Providers;

use App\Models\CashAdvance;
use App\Models\CaUsage;
use App\Policies\CashAdvancePolicy;
use App\Policies\CaUsagePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        CashAdvance::class => CashAdvancePolicy::class,
        CaUsage::class => CaUsagePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
