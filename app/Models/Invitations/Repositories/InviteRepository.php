<?php

namespace App\Models\Invitations\Repositories;

use App\Contracts\Repository;
use App\Models\Invitations\Entities\Invite as Invite;

class InviteRepository extends Repository {

    /**
     * Sets the model name
     * @return mixed
     */

    public function getModel(){
        return Invite::class;
    }

    /**
     * Get paginated collection
     *
     * @param  $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */

    public function getPaginatedInvitations($perPage){
        return $this->getQueryBuilder()
            ->orderBy('id', 'desc')
            ->paginate($perPage);
    }
}