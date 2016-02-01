<?php

namespace App\Policies;
use App\Contracts\PolicyContract;

class UserPolicy extends PolicyContract{
    /**
     * @param  User $user
     * @return bool
     * @Policy\PermissionMethod
     */
    public function index(User $user){
        return $user->hasPermissionTo(__CLASS__ . '.' . __METHOD__);
    }

    /**
     * @param User $user
     * @return bool
     * @Policy\PermissionMethod
     */

    public function create(User $user){
        return $user->hasPermissionTo(__CLASS__ . '.' . __METHOD__);
    }

    /**
     * @param User $user
     * @return bool
     * @Policy\PermissionMethod
     */

    public function update(User $user){
        return $user->hasPermissionTo(__CLASS__ . '.' . __METHOD__);
    }

    /**
     * @param User $user
     * @return bool
     * @Policy\PermissionMethod
     */

    public function delete(User $user){
        return $user->hasPermissionTo(__CLASS__ . '.' . __METHOD__);
    }

    /**
     * @param User $user
     * @return bool
     * @Policy\PermissionMethod
     */

    public function massDelete(User $user){
        return $user->hasPermissionTo(__CLASS__ . '.' . __METHOD__);
    }
}