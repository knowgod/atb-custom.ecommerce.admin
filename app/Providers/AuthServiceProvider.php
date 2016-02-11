<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Policies;
use App\Models;

class AuthServiceProvider extends ServiceProvider {
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
            Policies\UserPolicy::class  => Policies\UserPolicy::class,
            Policies\OrderPolicy::class       => Policies\OrderPolicy::class,
            Policies\InvitationPolicy::class => Policies\InvitationPolicy::class,
            Policies\PermissionPolicy::class => Policies\PermissionPolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function boot(GateContract $gate){
        $this->registerPolicies($gate);

    }
}
