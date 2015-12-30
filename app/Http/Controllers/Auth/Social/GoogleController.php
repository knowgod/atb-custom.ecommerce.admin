<?php

/**
 * @category Atypicalbrands
 * Written by: vyatsyuk@atypicalbrands.com
 * Date: 30.12.15
 *
 */

namespace App\Http\Controllers\Auth\Social;

use App\User;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Auth;
use Validator;
use Socialite;

class GoogleController extends AuthController {
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return Response
     */

    public function redirectToProvider(){
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return void
     */
    public function handleProviderCallback(){

        $googleUser = Socialite::driver('google')->user();

        $user = User::whereEmail($googleUser->getEmail())->first(['id']);

        if (!$user){
            $user = User::create(
                    ['firstname'         => $googleUser['name']['givenName'],
                     'lastname'          => $googleUser['name']['familyName'],
                     'email'             => $googleUser->getEmail(),
                     'google_id'         => $googleUser->getId(),
                     'password'          => bcrypt($googleUser->getId()),
                     'register_source'   => 'google',
                     'google_avatar_img' => $googleUser->getAvatar()
                    ]
            );
        }
        Auth::login($user);
        return redirect()->intended($this->redirectPath());
    }
}