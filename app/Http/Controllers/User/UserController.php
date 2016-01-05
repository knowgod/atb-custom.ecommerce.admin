<?php

/**
 * @category Atypicalbrands
 * Written by: vyatsyuk@atypicalbrands.com
 * Date: 29.12.15
 *
 */
namespace App\Http\Controllers\User;

use App\Users\Repositories\UserRepository;
use App\Http\Requests;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller {

    protected $redirectTo = '/user/list';
    protected $_itemsPerPage = 10;

    public $userRepo = null;

    public function __construct(UserRepository $userRepo){
        $this->userRepo = $userRepo;
    }

    public function index(){
        $users = $this->userRepo->paginate($this->_itemsPerPage);
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
        $validator = $this->createValidator($request->all());

        if ($validator->fails()){
            $this->throwValidationException(
                    $request, $validator
            );
        }
        $this->userRepo->create(
                ['fullname'        => $request->input('firstname') . ' ' . $request->input('lastname'),
                 'firstname'       => $request->input('firstname'),
                 'lastname'        => $request->input('lastname'),
                 'email'           => $request->input('email'),
                 'password'        => bcrypt($request->input('password')),
                 'register_source' => 'manual',
                ]
        );
        return redirect($this->redirectTo);
    }

    public function update(Request $request){
        $validator = $this->updateValidator($request->all());

        if ($validator->fails()){
            $this->throwValidationException(
                    $request, $validator
            );
        }
        $user = $this->userRepo->findOrFail($request->input('id'));

        $this->userRepo->update(
                ['firstname'       => $request->input('firstname'),
                 'lastname'        => $request->input('lastname'),
                 'fullname'        => $request->input('firstname') . ' ' . $request->input('lastname'),
                 'email'           => $request->input('email'),
                 'register_source' => 'manual',
                ], $user->id);

        if ($request->has('password')){
            $this->userRepo->update(
                    ['password' => bcrypt($request->input('password')),
                    ], $user->id);
        }
        return redirect($this->redirectTo);

    }

    public function delete(){
        return 'delete action';
    }

    public function showCreateForm(){
        return view('user.create');
    }

    public function showUpdateForm(Request $request, $id){
        $user = $this->userRepo->findOrFail($id);
        return view('user.update', array('user' => $user));
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
                'lastname'  => 'required|max:255',
        ];
        if ($data['password']){
            array_merge($rulesSet, ['password' => 'required|confirmed|min:6']);
        }

        return Validator::make($data, $rulesSet);
    }


}