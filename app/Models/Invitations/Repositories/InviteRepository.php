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

    public function orderBy($field, $direction){
        $this->getQueryBuilder()->orderBy($field, $direction);
        return $this;
    }

    public function applyFilters($filterData){
        foreach ($filterData as $fieldName => $filterValue){
            if ($filterValue){
                $this->findBy($fieldName, ['like' => $filterValue]);
            }
        }
        return $this;
    }

    public function getInvitationByEmail($email)
    {
        return $this->getQueryBuilder()
            ->where('email', 'like', $email)
            ->first(['email']);
    }
}