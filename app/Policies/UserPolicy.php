<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Users\Entities\User as User;


class UserPolicy {
    use HandlesAuthorization;

    /**
     * @param  User $user
     * @return bool
     * @Policy\PermissionMethod
     */
    public function index(User $user){

        return $user->hasPermissionTo(__CLASS__ . '.' . __METHOD__);
        //check here
        return true;
    }

    /**
     * @param User $user
     * @return bool
     * @Policy\PermissionMethod
     */

    public function create(User $user){
        $u = $user;
        //check here
        return true;
    }

    /**
     * @param User $user
     * @return bool
     * @Policy\PermissionMethod
     */

    public function update(User $user){
        $u = $user;
        //check here
        return true;
    }

    /**
     * @param User $user
     * @return bool
     * @Policy\PermissionMethod
     */

    public function delete(User $user){
        $u = $user;
        //check here
        return true;
    }

    /**
     * @param User $user
     * @return bool
     * @Policy\PermissionMethod
     */

    public function massDelete(User $user){
        $u = $user;
        //check here
        return true;
    }

    /**
     * @param $policyName
     * @param $permissionName
     */
    public function isAllowed($policyName, $permissionName){

    }
}
