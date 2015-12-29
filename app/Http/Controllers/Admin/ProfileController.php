<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{

    public function index()
    {
        return view('profile.index');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Update the user's profile.
     *
     * @param  Request  $request
     * @return Response
     */
    public function updateProfile(Request $request)
    {
/*        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }*/

        if ($request->user()) {

            // $request->user() returns an instance of the authenticated user...
        }
    }
}