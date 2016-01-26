<?php

namespace App\Policies;

use App\Contracts\PolicyContract;

class OrderPolicy extends PolicyContract {
    /**
     * @param User $user
     * @return bool
     * @Policy\PermissionMethod
     */
    public function index(User $user){
        return $user->hasPermissionTo(__CLASS__ . '.' . __METHOD__);
    }
}
