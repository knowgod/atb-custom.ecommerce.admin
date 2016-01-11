<?php

namespace App\Models\Users\Repositories;

use App\Contracts\Repository;
use App\Models\Users\Entities\User as User;

/**
 * @category Atypicalbrands
 * Written by: vyatsyuk@atypicalbrands.com
 * Date: 05.01.16
 *
 */
class UserRepository extends Repository {

    /**
     * Sets the model name
     * @return mixed
     */

    public function getModel(){
        return User::class;
    }

    /**
     * Get paginated collection
     *
     * @param  $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */

    public function getPaginatedUsers($perPage){
        return $this->getQueryBuilder()
                ->orderBy('id', 'desc')
                ->paginate($perPage);
    }
}

