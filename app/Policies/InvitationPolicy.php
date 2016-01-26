<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Users\Entities\User as User;


class InvitationPolicy {
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     * @return void
     */
    public function __construct(){
    }

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
