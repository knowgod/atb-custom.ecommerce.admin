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
            Models\Users\Entities\User::class         => Policies\UserPolicy::class,
            Models\Orders\Entities\Order::class       => Policies\OrderPolicy::class,
            Models\Invitations\Entities\Invite::class => Policies\InvitationPolicy::class,
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
