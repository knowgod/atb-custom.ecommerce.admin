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
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaravelDoctrine\ACL\Permissions\PermissionManager;


class RoleController extends Controller {

    protected $redirectTo = '/role/list';

    protected $_itemsPerPage = 20;

    public $roleRepo = null;

    public function __construct(RoleRepository $roleRepo){
        $this->roleRepo = $roleRepo;
    }

    public function index(Request $request){

        $collectionParams = $this->prepareGridCollectionParams($request);

        $roles = $this->roleRepo->getGridCollection(
                $collectionParams['filterBy'],
                $collectionParams['orderBy'],
                $collectionParams['perPage']
        );

        return view('role.list', array('collection' => $roles));
    }

    public function create(){
        /**
         * @var $r Role
         */
        $r = $this->roleRepo->findOneBy(['name'=>'Some Test Role'], null, 1);
        if($r){
            $r->hasPermissionTo(['user.update']);
            $r->hasPermissionTo(['waka']);
            var_dump($r);
            die;
        }


        $role = new Role();
        $role->setName('Some Test Role');
        $role->setPermissions(['UserPolicy.create','UserPolicy.update']);
        $role->save();
        return 'OK';
    }
}




