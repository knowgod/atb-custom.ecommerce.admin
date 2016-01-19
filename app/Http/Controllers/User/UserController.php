<?php

/**
 * @category Atypicalbrands
 * Written by: vyatsyuk@atypicalbrands.com
 * Date: 29.12.15
 *
 */
namespace App\Http\Controllers\User;

use App\Models\Users\Repositories\UserRepository;
use App\Models\Users\Entities\User;

use App\Http\Requests;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller {

    protected $redirectTo = '/user/list';

    protected $_itemsPerPage = 15;

    public $userRepo = null;

    public function __construct(UserRepository $userRepo){
        $this->userRepo = $userRepo;
    }

    public function index(Request $request){

        $collectionParams = $this->prepareGridCollectionParams($request);

        $users = $this->userRepo->getUserGridCollection(
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
        $user = $this->userRepo->find($id);
        $user->remove();
        return redirect($this->redirectTo);
    }

    public function massDelete(Request $request){
        /**
         * @var $item User
         */

        if (!$request->has('items')){
            return redirect($this->redirectTo);
        }
        $items = $this->userRepo->findBy(array('id' => $request->get('items')));
        foreach ($items as $item){
            $item->remove();
        }

        return redirect($this->redirectTo)->with('grid_collection_query', $request->get('query'));
    }

    public function showCreateForm(){
        return view('user.create');
    }

    public function showUpdateForm(Request $request, $id){
        $user = $this->userRepo->find($id);
        return view('user.update', array('user' => $user));
    }

    protected function prepareGridCollectionParams(Request $request){
        //TODO: create a separate class to hold grid params and move this...

        $gridParams = [
            'orderBy'=> [],
            'filterBy'=>[],
            'perPage'=>null
        ];
        $sessionQueryData = \Session::get('grid_collection_query');
        if($sessionQueryData){
            $gridParams['orderBy'] = [
                'orderBy'=>$sessionQueryData['orderBy'],
                'orderDirection'=>$sessionQueryData['orderDirection'],
            ];
            $gridParams['perPage'] = (isset($sessionQueryData['perPage'])) ? $sessionQueryData['perPage'] : $this->_itemsPerPage;
            return $gridParams;
        }

        $gridParams['filterBy'] = ($request->has('filterBy')) ? $request->input('filterBy') : [];
        $gridParams['orderBy'] = ($request->has(['orderBy', 'orderDirection'])) ?
                [
                        'orderBy'        => $request->input('orderBy'),
                        'orderDirection' => $request->input('orderDirection')
                ] : [];

        $gridParams['perPage'] = ($request->has('perPage') ? $request->input('perPage') : $this->_itemsPerPage);
        return $gridParams;
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