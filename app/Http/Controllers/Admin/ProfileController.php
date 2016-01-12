<?php

namespace App\Http\Controllers\Admin;

use App\Models\Users\Repositories\UserRepository;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Auth;

class ProfileController extends Controller
{

    protected $redirectTo = '/profile';

    public $userRepo = null;

    public function __construct(UserRepository $userRepo){
        $this->userRepo = $userRepo;
    }

    public function index()
    {
        return view('profile.index', ['user'=>Auth::user()]);
    }

    /**
     * Update the user's profile.
     *
     * @param  Request  $request
     * @return Response
     */

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

    protected function updateValidator(array $data){
        $rulesSet = [
                'firstname' => 'required|max:255',
                'email'     => 'required|email|max:255|unique:users',
                'lastname'  => 'required|max:255',
        ];
        if (isset($data['password'])){
            array_merge($rulesSet, ['password' => 'required|confirmed|min:6']);
        }

        return Validator::make($data, $rulesSet);
    }
}