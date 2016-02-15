<?php

/**
 * @category Atypicalbrands
 * Written by: vyatsyuk@atypicalbrands.com
 * Date: 21.01.16
 *
 */
namespace App\Contracts;

use Doctrine\ORM\EntityRepository;
use LaravelDoctrine\ORM\Pagination\Paginatable;
use LaravelDoctrine\ORM\Pagination\PaginatorAdapter;
use Doctrine\ORM\Query;

abstract class DoctrineRepository extends EntityRepository{
    use Paginatable;

    protected $_defaultAlias = 'tbl';

    protected $_defaultSortBy = 'id';
    protected $_defaultSortOrder = 'DESC';

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

    /**
      * Get filtered, ordered and paginated collection
      *
      * @param  $perPage
      * @return \Illuminate\Pagination\LengthAwarePaginator
      */

     public function getGridCollection(RepositoryFilterContract $repoFilter){
         $filterParams = $repoFilter->getFilterBy();
         $order = $repoFilter->getOrderBy();
         $perPage = $repoFilter->getPerPage();

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
}