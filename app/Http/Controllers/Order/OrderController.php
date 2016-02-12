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

use App\Policies\OrderPolicy as AclPolicy;

class OrderController extends Controller {

    protected $redirectTo = '/order/list';
    protected $_itemsPerPage = 15;

    public $orderRepo = null;

    public function __construct(OrderRepository $orderRepo){
        $this->orderRepo = $orderRepo;
    }

    public function index(Request $request){

        $this->authorize('index', new AclPolicy());

        $collectionParams = $this->prepareGridCollectionParams($request);

        $orders = $this->orderRepo->getOrderGridCollection(
                $collectionParams['filterBy'],
                $collectionParams['orderBy'],
                $collectionParams['perPage']
        );

        $orderStatusesCount = $this->orderRepo->getOrdersStatusesCount();

        $this->addNotify('success', 'Order collection is loaded!');

        return view('order.list', ['collection'           => $orders,
                                   'notifications'        => $this->_notifications,
                                   'order_statuses_count' => $orderStatusesCount]
        );
    }

    public function view(Request $request, $id){
        $order = $this->orderRepo->find($id);
        return view('order.view', ['order' => $order]);
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

    public function showGrid(Request $request){
        $collectionParams = $this->prepareGridCollectionParams($request);

        $orders = $this->orderRepo->getOrderGridCollection(
            $collectionParams['filterBy'],
            $collectionParams['orderBy'],
            $collectionParams['perPage']
        );

        return view('order.grid',['collection' => $orders]);
    }

    public function bulkDelete(Request $request){
        /**
         * @var $item User
         */

        if (!$request->has('items')){
            return redirect($this->redirectTo);
        }
        $items = $this->orderRepo->findBy(array('id' => $request->get('items')));
        foreach ($items as $item){
            $item->remove();
        }
        return redirect($this->redirectTo)->with('grid_collection_query', $request->get('query'));
    }

}