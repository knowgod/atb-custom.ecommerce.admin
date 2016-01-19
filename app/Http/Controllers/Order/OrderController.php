<?php

/**
 * @category Atypicalbrands
 * Written by: vyatsyuk@atypicalbrands.com
 * Date: 29.12.15
 *
 */

namespace App\Http\Controllers\Order;

use App\Models\Orders\Repositories\OrderRepository;
use App\Models\Orders\Entities\Order;

use App\Http\Requests;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller {

    protected $redirectTo = '/order/list';
    protected $_itemsPerPage = 15;

    public $orderRepo = null;

    public function __construct(OrderRepository $orderRepo){
        $this->orderRepo = $orderRepo;
    }

    public function index(Request $request){

        $collectionParams = $this->prepareGridCollectionParams($request);

        $orders = $this->orderRepo->getOrderGridCollection(
                $collectionParams['filterBy'],
                $collectionParams['orderBy'],
                $collectionParams['perPage']
        );

        return view('order.list', array('collection' => $orders));
    }

    public function view(Request $request, $id){
        $order = $this->orderRepo->find($id);
        return view('order.view', ['order'=>$order]);
    }

    public function create(Request $request){
        return redirect($this->redirectTo);
    }

    public function update(Request $request){
        return redirect($this->redirectTo);
    }

    public function delete($id){
        return redirect($this->redirectTo);
    }

    public function showCreateForm(){
        return view('order.create');
    }

}