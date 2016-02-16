<?php

/**
 * @category Atypicalbrands
 * Written by: vyatsyuk@atypicalbrands.com
 * Date: 21.01.16
 *
 */
namespace App\Http\Controllers\Acl;

use App\Http\Requests;
use App\Models\Acl\Entities\Role as Role;
use App\Models\Acl\Repositories\RoleRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\RepositoryFilter;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaravelDoctrine\ACL\Permissions\PermissionManager;


class RoleController extends Controller {

    protected $redirectTo = '/role/list';

    public $roleRepo = null;

    public $repositoryFilter;

    public function __construct(RoleRepository $roleRepo, RepositoryFilter $repositoryFilter){
        $this->roleRepo = $roleRepo;
        $this->repositoryFilter = $repositoryFilter;
    }

    public function index(Request $request){

        $roles = $this->roleRepo->getGridCollection(
                $this->repositoryFilter->prepareFromRequest($request)
        );

        return view('role.list', array('collection' => $roles));
    }

    public function store(Request $request){
        /**
         * @var $role Role
         */
        //$this->authorize('store', new AclPolicy());

        $validator = $this->createValidator($request->all());

        if ($validator->fails()){
            $this->throwValidationException(
                    $request, $validator
            );
        }
        $role = new Role();
        $role->setName('Some Test Role')
                ->setPermissions(['UserPolicy.create', 'UserPolicy.update'])
                ->save();
        return redirect($this->redirectTo);
    }

    public function update(Request $request){

        //$this->authorize('update', new AclPolicy());

        $validator = $this->updateValidator($request->all());

        if ($validator->fails()){
            $this->throwValidationException(
                    $request, $validator
            );
            return;
        }
        /**
         * @var $role Role
         */
        $role = $this->roleRepo->find($request->input('id'));

        $role->setName()
                ->setPermissions(['*'])
                ->save();
        return redirect($this->redirectTo);

    }

    public function delete($id){

        $this->authorize('delete', new AclPolicy());

        $user = $this->roleRepo->find($id);
        $user->remove();
        return redirect($this->redirectTo);
    }

    public function bulkDelete(Request $request){
        /**
         * @var $item Role
         */

        //$this->authorize('bulkDelete', new AclPolicy());

        if (!$request->has('items')){
            return redirect($this->redirectTo);
        }
        $items = $this->roleRepo->findBy(array('id' => $request->get('items')));
        foreach ($items as $item){
            $item->remove();
        }

        return redirect($this->redirectTo)->with('grid_collection_query', $request->get('query'));
    }

    public function create(PermissionManager $m){
        $permissions = $m->getAllPermissions();
        return view('role.create', ['permissions'=>$permissions]);
    }

    public function edit(Request $request, $id, PermissionManager $m){
        $role = $this->roleRepo->find($id);
        $permissions = $m->getAllPermissions();

        return view('role.update', array('role' => $role,'permissions'=>$permissions));
    }

    protected function createValidator(array $data){
        return Validator::make($data, [
                'name' => 'required|max:255|unique:roles',
        ]);
    }

    protected function updateValidator(array $data){
        $rulesSet = [
                'name' => 'required|max:255|unique:roles,' ,
        ];
        return Validator::make($data, $rulesSet);
    }
}




