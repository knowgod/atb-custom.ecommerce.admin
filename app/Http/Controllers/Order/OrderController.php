<?php

/**
 * @category Atypicalbrands
 * Written by: vyatsyuk@atypicalbrands.com
 * Date: 29.12.15
 *
 */

namespace App\Http\Controllers\Order;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Policies\OrderPolicy as AclPolicy;

class OrderController extends Controller {

    protected $redirectTo = '/order/list';

    public function index(Request $request){

        $this->authorize('index', new AclPolicy());
        return view('order.list');
    }

    public function view(Request $request, $id){
        $this->authorize('view', new AclPolicy());
        return view('order.view');
    }
}