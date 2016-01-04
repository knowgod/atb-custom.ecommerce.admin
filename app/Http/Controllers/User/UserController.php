<?php

/**
 * @category Atypicalbrands
 * Written by: vyatsyuk@atypicalbrands.com
 * Date: 29.12.15
 *
 */
namespace App\Http\Controllers\User;

use App\User;
use App\Http\Requests;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller {

    protected $redirectTo = '/user/list';
    protected $_itemsPerPage = 10;

    public function __construct(){
    }

    public function index(){
        $users = User::paginate($this->_itemsPerPage);
        return view('user.list', array('users' => $users));
    }

    public function view(){
        return view('user.view');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request){
        $validator = $this->validator($request->all());

        if ($validator->fails()){
            $this->throwValidationException(
                    $request, $validator
            );
        }
        User::create(
                ['firstname'       => $request->input('firstname'),
                 'lastname'        => $request->input('lastname'),
                 'email'           => $request->input('email'),
                 'password'        => bcrypt($request->input('password')),
                 'register_source' => 'manual',
                ]
        );
        return redirect($this->redirectTo);

    }

    public function update(){
        return view('user.update');
    }

    public function delete(){
        return 'delete action';
    }

    public function showCreateForm(){
        return view('user.create');
    }

    protected function validator(array $data){
        return Validator::make($data, [
                'firstname' => 'required|max:255',
                'lastname'  => 'required|max:255',
                'email'     => 'required|email|max:255|unique:users',
                'password'  => 'required|confirmed|min:6',
        ]);
    }

}