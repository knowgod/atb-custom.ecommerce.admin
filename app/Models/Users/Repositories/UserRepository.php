<?php

namespace App\Models\Users\Repositories;

use App\Models\Users\Entities\User as User;
use Doctrine\ORM\Query;
use App\Contracts\DoctrineRepository;

/**
 * @category Atypicalbrands
 * Written by: vyatsyuk@atypicalbrands.com
 * Date: 05.01.16
 *
 */
class UserRepository extends DoctrineRepository {
    /**
     * Get filtered, ordered and paginated collection
     *
     * @param  $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */

    public function getUserGridCollection($filterParams, $order, $perPage){
        $qb = $this->_em->createQueryBuilder();

        $qb->select($this->_defaultAlias)
                ->from($this->getEntityName(), $this->_defaultAlias)
                ->orderBy($this->_defaultAlias . '.' . $this->_defaultSortBy, $this->_defaultSortOrder);

        foreach ($filterParams as $fieldName => $filterValue){
            if ($filterValue){
                $qb->where($qb->expr()->like($this->_defaultAlias . '.' . $fieldName, $qb->expr()->literal('%' . $filterValue. '%')));
            }
        }
        if($order){
            $qb->orderBy($this->_defaultAlias . '.' . $order['orderBy'], $order['orderDirection']);
        }

        return $this->paginate($qb->getQuery(), $perPage);
    }
}

