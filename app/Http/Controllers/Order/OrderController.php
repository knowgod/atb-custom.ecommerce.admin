<?php

/**
 * @category Atypicalbrands
 * Written by: vyatsyuk@atypicalbrands.com
 * Date: 29.12.15
 *
 */

namespace App\Http\Controllers\Order;

use App\Http\Requests;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller {

    protected $redirectTo = '/order/list';
    protected $_itemsPerPage = 10;

    public $userRepo = null;

/*    public function __construct(){
    }*/

    public function index(Request $request){
        return view('order.list', array('collection' => [
            ['a'=>1, 'waka'=>'test'],['b'=>2, 'beta' => 2]
        ]));
    }

    public function view(){
        return view('order.view');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

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

    public function showUpdateForm(Request $request, $id){
        return view('order.update', array('order' => []));
    }

    protected function createValidator(array $data){
        return Validator::make($data, [
                'firstname' => 'required|max:255',
                'lastname'  => 'required|max:255',
                'email'     => 'required|email|max:255|unique:users',
                'password'  => 'required|confirmed|min:6',
        ]);
    }

    protected function updateValidator(array $data){
        $rulesSet = [
                'firstname' => 'required|max:255',
                //'email'     => 'required|email|max:255|unique:users',
                'lastname'  => 'required|max:255',
                'password'  => 'sometimes|required|confirmed|min:6'
        ];

        return Validator::make($data, $rulesSet);
    }

}