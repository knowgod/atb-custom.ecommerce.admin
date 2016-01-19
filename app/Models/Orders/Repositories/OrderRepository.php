<?php

namespace App\Models\Orders\Repositories;

use App\Models\Orders\Entities\Order as Order;
use Doctrine\ORM\EntityRepository;
use LaravelDoctrine\ORM\Pagination\Paginatable;
use LaravelDoctrine\ORM\Pagination\PaginatorAdapter;
use Doctrine\ORM\Query;

/**
 * @category Atypicalbrands
 * Written by: vyatsyuk@atypicalbrands.com
 * Date: 05.01.16
 *
 */
class OrderRepository extends EntityRepository {
    use Paginatable;

    protected $_defaultAlias = 'tbl';

    protected $_defaultSortBy = 'id';
    protected $_defaultSortOrder = 'DESC';
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
        $query = $this->_em->createQuery('SELECT u.status, COUNT(u.id) as cnt FROM ' . $this->getEntityName() . ' u GROUP BY u.status');
        return $query->getResult();

    }

    /**
     * Finds an entity by its primary key / identifier.
     *
     * @param mixed    $id          The identifier.
     * @param int|null $lockMode    One of the \Doctrine\DBAL\LockMode::* constants
     *                              or NULL if no specific lock mode should be used
     *                              during the search.
     * @param int|null $lockVersion The lock version.
     *
     * @return Order|null The User instance or NULL if the entity can not be found.
     */
    public function find($id, $lockMode = null, $lockVersion = null)
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

    /**
     * Finds a single entity by a set of criteria.
     *
     * @param array $criteria
     * @param array|null $orderBy
     *
     * @return Order|null The User instance or NULL if the entity can not be found.
     */
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        return parent::findOneBy($criteria, $orderBy);
    }

    /**
     * @param Query  $query
     * @param int    $perPage
     * @param bool   $fetchJoinCollection
     * @param string $pageName
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate(Query $query, $perPage, $pageName = 'page', $fetchJoinCollection = false)
    {
        return (new PaginatorAdapter())->make(
            $query,
            $perPage,
            $pageName,
            $fetchJoinCollection
        );
    }

}

