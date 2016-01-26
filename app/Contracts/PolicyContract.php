<?php

/**
 * @category Atypicalbrands
 * Written by: vyatsyuk@atypicalbrands.com
 * Date: 26.01.16
 *
 */

namespace App\Contracts;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Users\Entities\User as User;

abstract class PolicyContract{

    const WILDCARD_PERMISSION = '*';

    use HandlesAuthorization;

    public function before(User $user)
    {
        return $user->hasPermissionTo('*');
    }

}
