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
use App\Http\RepositoryFilter;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Policies\UserPolicy as AclPolicy;

class UserController extends Controller {

    protected $redirectTo = '/user/list';

    public $userRepo = null;

    public $roleRepo = null;

    public $repositoryFilter;

    public function __construct(UserRepository $userRepo, RepositoryFilter $repositoryFilter, RoleRepository $roleRepo){
        $this->userRepo = $userRepo;
        $this->repositoryFilter = $repositoryFilter;
        $this->roleRepo = $roleRepo;
    }

    public function index(Request $request){

        $this->authorize('index', new AclPolicy());

        $users = $this->userRepo->getGridCollection(
                $this->repositoryFilter->prepareFromRequest($request)
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

    public function store(Requests\User\UserFormRequest $request){

        $this->authorize('store', new AclPolicy());

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

    public function update(Requests\User\UserFormRequest $request){

        $this->authorize('update', new AclPolicy());

        $user = $this->userRepo->find($request->input('id'));

        $user->setFirstname($request->input('firstname'))
                ->setLastname($request->input('lastname'))
                ->setFullname($request->input('firstname') . ' ' . $request->input('lastname'))
                ->setEmail($request->input('email'));

        if($request->has('user_role')){
            $role =  $this->roleRepo->find($request->input('user_role'));
            $user->grantRole($role);
        }

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

    public function bulkDelete(Request $request){
        /**
         * @var $item User
         */

        $this->authorize('bulkDelete', new AclPolicy());

        if (!$request->has('items')){
            return redirect($this->redirectTo);
        }
        $items = $this->userRepo->findBy(array('id' => $request->get('items')));
        foreach ($items as $item){
            $item->remove();
        }

        return redirect($this->redirectTo)->with('grid_collection_query', $request->get('query'));
    }

    public function create(RoleRepository $rolesRepo){
        return view('user.create', ['roles_list' => $rolesRepo->findAll()]);
    }

    public function edit(Request $request, $id, RoleRepository $rolesRepo){
        $user = $this->userRepo->find($id);
        return view('user.update', array('user' => $user, 'user_role' => $user->getRole(), 'roles_list' => $rolesRepo->findAll()));
    }
}