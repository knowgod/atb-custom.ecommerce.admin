<?php

namespace App\Policies;
use App\Contracts\PolicyContract;

class InvitationPolicy extends PolicyContract{
    /**
     * @param  User $user
     * @Policy\PermissionMethod
     * @return bool
     */
    public function index(User $user){
        return $user->hasPermissionTo(__CLASS__ . '.' . __METHOD__);
    }

    /**
     * @param  User $user
     * @Policy\PermissionMethod
     * @return bool
     */
    public function sendEmail(User $user){
        return $user->hasPermissionTo(__CLASS__ . '.' . __METHOD__);
    }
}
