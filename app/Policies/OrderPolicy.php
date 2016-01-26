<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Users\Entities\User as User;

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
        return $user->hasPermissionTo(__CLASS__ . '.' . __METHOD__);
    }
}
