<?php

namespace App\Http\Controllers;

use App\Http\GridFilter;
use App\Contracts\RepositoryFilterContract;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;


class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $_notifications = [];

    protected function addNotify($type, $text){
        array_push($this->_notifications, ['type' => $type, 'text' => $text]);
        return;
    }
}
