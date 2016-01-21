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
}