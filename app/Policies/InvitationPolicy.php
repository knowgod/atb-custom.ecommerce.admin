<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;


class InvitationPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     * @return void
     */
    public function __construct()
    {

        //
    }

    /**
     * @param  User  $user
     * @Policy\PermissionMethod
     * @return bool
     */
    public function index(User $user)
    {
        //check here
        return true;
    }

}
