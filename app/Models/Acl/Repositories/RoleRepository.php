<?php

/**
 * @category Atypicalbrands
 * Written by: vyatsyuk@atypicalbrands.com
 * Date: 21.01.16
 *
 */

namespace App\Models\Acl\Repositories;

use App\Models\Acl\Entities\Role as Role;
use Doctrine\ORM\Query;

use App\Contracts\DoctrineRepository;

class RoleRepository extends DoctrineRepository {

    public function getGridCollection($filterParams, $order, $perPage){
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