<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        \BetaGT\UserAclManager\UserAclManager::routes();
        Passport::routes(null, [
            'prefix' => 'api/v1','middleware' => ['cors']
        ]);
        Passport::tokensExpireIn(Carbon::now()->addHour(5));
        Passport::refreshTokensExpireIn(Carbon::now()->addDay(1));
    }
}