<?php

namespace App\Users\Repositories;

use App\Contracts\Repository;
use App\Users\Entities\User as User;

/**
 * @category Atypicalbrands
 * Written by: vyatsyuk@atypicalbrands.com
 * Date: 05.01.16
 *
 */

class UserRepository extends Repository {

    public function __construct(){
        
    }

    public function model(){
        return User::class;
    }
}

