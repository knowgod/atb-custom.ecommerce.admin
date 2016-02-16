<?php

namespace App\Http\Controllers\Admin;

use App\Models\Users\Repositories\UserRepository;
use App\Models\Users\Repositories\User;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class ProfileController extends Controller {

    protected $redirectTo = '/profile';

    public $userRepo = null;

    public function __construct(UserRepository $userRepo){
        $this->userRepo = $userRepo;
    }

    public function index(){
        return view('profile.index', ['user' => Auth::user()]);
    }

    /**
     * Update the user's profile.
     *
     * @param  Request $request
     * @return Response
     */

    public function update(Requests\Admin\ProfileFormRequest $request){

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
}