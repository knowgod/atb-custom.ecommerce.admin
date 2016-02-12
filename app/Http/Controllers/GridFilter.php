<?php

/**
 * @category Atypicalbrands
 * Written by: vyatsyuk@atypicalbrands.com
 * Date: 12.02.16
 *
 */
namespace App\Http;
use App\Contracts\RepositoryFilterContract;

class GridFilter extends RepositoryFilterContract {

    public function getOrderBy(){
        return $this->_order;
    }

    public function getPerPage(){
        return $this->_perPage;
    }

    public function getFilterBy(){
        return $this->_params;
    }
}