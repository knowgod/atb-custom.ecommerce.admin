<?php

namespace App\Http\Controllers;

use App\Http\GridFilter;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;


class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $_notifications = [];

    protected function prepareGridCollectionParams(Request $request){
        //TODO: create a separate class to hold grid params and move this...

        $gridParams = new GridFilter();

        $sessionQueryData = \Session::get('grid_collection_query');
        if ($sessionQueryData){
            $gridParams->setOrderBy([
                    'orderBy'        => $sessionQueryData['orderBy'],
                    'orderDirection' => $sessionQueryData['orderDirection'],
            ]);
            $gridParams->setPerPage((isset($sessionQueryData['perPage'])) ? $sessionQueryData['perPage'] : $this->_itemsPerPage);
            return $gridParams;
        }
        $gridParams->setFilterBy(($request->has('filterBy')) ? $request->input('filterBy') : []);

        $orderBy = ($request->has(['orderBy', 'orderDirection'])) ?
                [
                        'orderBy'        => $request->input('orderBy'),
                        'orderDirection' => $request->input('orderDirection')
                ] : [];
        $gridParams->setOrderBy($orderBy);
        $gridParams->setPerPage($request->has('perPage') ? $request->input('perPage') : $this->_itemsPerPage);
        
        return $gridParams;
    }

    protected function addNotify($type, $text){
        array_push($this->_notifications, ['type' => $type, 'text' => $text]);
        return;
    }
}
