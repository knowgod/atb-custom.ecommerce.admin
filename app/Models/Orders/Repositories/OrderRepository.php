<?php

namespace App\Models\Orders\Repositories;

use App\Models\Orders\Entities\Order as Order;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use App\Contracts\DoctrineRepository;

/**
 * @category Atypicalbrands
 * Written by: vyatsyuk@atypicalbrands.com
 * Date: 05.01.16
 *
 */
class OrderRepository extends DoctrineRepository {

    /**
     * Get filtered, ordered and paginated collection
     *
     * @param  $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */

    public function getOrderGridCollection($filterParams, $order, $perPage){
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

    public function getOrdersStatusesCount(){
        $result = array();

        $query = $this->_em->createQuery('SELECT u.status, COUNT(u.id) as cnt FROM ' . $this->getEntityName() . ' u GROUP BY u.status');
        $rows = $query->getResult();

        foreach($rows as $item){
            $result[$item['status']] = $item['cnt'];
        }
        return $result;
    }

}

