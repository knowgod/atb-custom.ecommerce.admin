<?php

/**
 * @category Atypicalbrands
 * Written by: vyatsyuk@atypicalbrands.com
 * Date: 12.02.16
 *
 */
namespace App\Http;
use App\Contracts\RepositoryFilterContract;
use Illuminate\Http\Request;

class RepositoryFilter extends RepositoryFilterContract {

    public function getOrderBy(){
        return $this->_order;
    }

    public function getPerPage(){
        return $this->_perPage;
    }

    public function getFilterBy(){
        return $this->_params;
    }

    public function prepareFromRequest(Request $request){
        $sessionQueryData = \Session::get('grid_collection_query');
        if ($sessionQueryData){
            $this->setOrderBy([
                    'orderBy'        => $sessionQueryData['orderBy'],
                    'orderDirection' => $sessionQueryData['orderDirection'],
            ]);
            $this->setPerPage((isset($sessionQueryData['perPage'])) ? $sessionQueryData['perPage'] : $this->_perPage);
            return $this;
        }
        $this->setFilterBy(($request->has('filterBy')) ? $request->input('filterBy') : []);

        $orderBy = ($request->has(['orderBy', 'orderDirection'])) ?
                [
                        'orderBy'        => $request->input('orderBy'),
                        'orderDirection' => $request->input('orderDirection')
                ] : [];
        $this->setOrderBy($orderBy);
        $this->setPerPage($request->has('perPage') ? $request->input('perPage') : $this->_perPage);

        return $this;
    }
}