<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Users\Entities\User as User;


class UserPolicy
{
    protected $_entityName;

    use HandlesAuthorization;

    /**
     * @param  User  $user
     * @return bool
     */
    public function index(User $user)
    {
        //check here
        return true;
    }
}
