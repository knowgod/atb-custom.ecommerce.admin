<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
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
     * @param User $user
     * @return bool
     * @Policy\PermissionMethod
     */
    public function index(User $user)
    {
        //check here
        return true;
    }

    /**
     * @param User $user
     * @Policy\PermissionMethod
     */

    public function whoop(User $user){

    }
}
