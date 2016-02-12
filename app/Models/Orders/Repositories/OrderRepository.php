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

    public function getOrdersStatusesCount(){
        $result = array();

        $query = $this->_em->createQuery('SELECT u.status, COUNT(u.id) as cnt FROM ' . $this->getEntityName() . ' u GROUP BY u.status');
        $rows = $query->getResult();

        foreach ($rows as $item){
            $result[$item['status']] = $item['cnt'];
        }
        return $result;
    }

}

