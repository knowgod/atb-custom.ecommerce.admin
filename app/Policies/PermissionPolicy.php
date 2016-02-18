<?php

namespace App\Policies;
use App\Contracts\PolicyContract;

class PermissionPolicy extends PolicyContract{
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
    public function create(User $user){
        return $user->hasPermissionTo(__CLASS__ . '.' . __METHOD__);
    }

    /**
     * @param  User $user
     * @Policy\PermissionMethod
     * @return bool
     */
    public function update(User $user){
        return $user->hasPermissionTo(__CLASS__ . '.' . __METHOD__);
    }

    /**
     * @param  User $user
     * @Policy\PermissionMethod
     * @return bool
     */
    public function delete(User $user){
        return $user->hasPermissionTo(__CLASS__ . '.' . __METHOD__);
    }

    /**
     * @param  User $user
     * @Policy\PermissionMethod
     * @return bool
     */
    public function massDelete(User $user){
        return $user->hasPermissionTo(__CLASS__ . '.' . __METHOD__);
    }

}