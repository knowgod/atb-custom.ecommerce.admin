<?php

namespace App\Models\Invitations\Repositories;

use App\Contracts\DoctrineRepository;
use App\Models\Invitations\Entities\Invitation as Invitation;

class InvitationRepository extends DoctrineRepository {

    /**
      * Get filtered, ordered and paginated collection
      *
      * @param  $perPage
      * @return \Illuminate\Pagination\LengthAwarePaginator
      */

     public function getInvitationsGridCollection($filterParams, $order, $perPage){
         $qb = $this->_em->createQueryBuilder();

         $qb->select($this->_defaultAlias)
                 ->from($this->getEntityName(), $this->_defaultAlias)
                 ->orderBy($this->_defaultAlias . '.' . $this->_defaultSortBy, $this->_defaultSortOrder);

         foreach ($filterParams as $fieldName => $filterValue){
             if ($filterValue){
                 $qb->andWhere($qb->expr()->like($this->_defaultAlias . '.' . $fieldName, $qb->expr()->literal('%' . $filterValue. '%')));
             }
         }
         if($order){
             $qb->orderBy($this->_defaultAlias . '.' . $order['orderBy'], $order['orderDirection']);
         }

         return $this->paginate($qb->getQuery(), $perPage);
     }

    public function getInvitationByEmail($email)
    {
        return $this->getQueryBuilder()
            ->where('email', 'like', $email)
            ->first(['email']);
    }
}