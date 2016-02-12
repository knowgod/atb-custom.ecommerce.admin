<?php

/**
 * @category Atypicalbrands
 * Written by: vyatsyuk@atypicalbrands.com
 * Date: 29.12.15
 *
 */
namespace App\Http\Controllers\User;

use App\Models\Acl\Repositories\RoleRepository;
use App\Models\Users\Repositories\UserRepository;
use App\Models\Users\Entities\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Policies\UserPolicy as AclPolicy;

class UserController extends Controller {

    protected $redirectTo = '/user/list';

    protected $_itemsPerPage = 15;

    public $userRepo = null;

    public function __construct(UserRepository $userRepo){
        $this->userRepo = $userRepo;
    }

    public function index(Request $request){

        $this->authorize('index', new AclPolicy());

        $collectionParams = $this->prepareGridCollectionParams($request);

        $users = $this->userRepo->getGridCollection(
                $collectionParams['filterBy'],
                $collectionParams['orderBy'],
                $collectionParams['perPage']
        );

        return view('user.list', array('collection' => $users));
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

        $this->authorize('create', new AclPolicy());

        $validator = $this->createValidator($request->all());

        if ($validator->fails()){
            $this->throwValidationException(
                    $request, $validator
            );
        }
        $user = new User();

        $user->setEmail($request->input('email'))
                ->setFirstname($request->input('firstname'))
                ->setLastname($request->input('lastname'))
                ->setFullname($request->input('firstname') . ' ' . $request->input('lastname'))
                ->setRegisterSource('manual')
                ->setPassword(bcrypt($request->input('password')));

        $user->save();

        return redirect($this->redirectTo);
    }

    public function update(Request $request){

        $this->authorize('update', new AclPolicy());

        $validator = $this->updateValidator($request->all());

        if ($validator->fails()){
            $this->throwValidationException(
                    $request, $validator
            );
        }
        $user = $this->userRepo->find($request->input('id'));

        $user->setFirstname($request->input('firstname'))
                ->setLastname($request->input('lastname'))
                ->setFullname($request->input('firstname') . ' ' . $request->input('lastname'))
                ->setEmail($request->input('email'));

        if ($request->has('password')){
            $user->setPassword(bcrypt($request->input('password')));
        }
        $user->save();
        return redirect($this->redirectTo);

    }

    public function delete($id){

        $this->authorize('delete', new AclPolicy());

        $user = $this->userRepo->find($id);
        $user->remove();
        return redirect($this->redirectTo);
    }

    public function massDelete(Request $request){
        /**
         * @var $item User
         */

        $this->authorize('massDelete', new AclPolicy());

        if (!$request->has('items')){
            return redirect($this->redirectTo);
        }
        $items = $this->userRepo->findBy(array('id' => $request->get('items')));
        foreach ($items as $item){
            $item->remove();
        }

        return redirect($this->redirectTo)->with('grid_collection_query', $request->get('query'));
    }

    public function showCreateForm(RoleRepository $rolesRepo){
        return view('user.create', ['roles_list' => $rolesRepo->findAll()]);
    }

    public function showUpdateForm(Request $request, $id, RoleRepository $rolesRepo){
        $user = $this->userRepo->find($id);
        return view('user.update', array('user' => $user, 'user_role' => $user->getRole(), 'roles_list' => $rolesRepo->findAll()));
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