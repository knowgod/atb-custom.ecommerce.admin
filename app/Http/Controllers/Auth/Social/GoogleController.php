<?php

/**
 * @category Atypicalbrands
 * Written by: vyatsyuk@atypicalbrands.com
 * Date: 30.12.15
 *
 */

namespace App\Http\Controllers\Auth\Social;

use App\Models\Users\Repositories\UserRepository;
use App\Models\Invitations\Repositories\InviteRepository;
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
    public function handleProviderCallback(UserRepository $userRepository, InviteRepository $inviteRepository){

        $googleUser = Socialite::driver('google')->user();

        $user = $userRepository->findBy('email', ['=' => $googleUser->getEmail()], ['id'])->first();
        $inviteExist = $inviteRepository->findBy('email', ['=' => $googleUser->getEmail()], ['id'])->first();

        if (!$inviteExist) {
            return redirect('/login/');
        }

        if (!$user){
            $fullName = $googleUser->getName();
            if (!$fullName){
                $fullName = "Unknown Unknown";
            }
            $nameParts = explode(' ', $fullName);
            $firstName = $googleUser['name']['givenName'] ? $googleUser['name']['givenName'] : $nameParts[0];
            $lastName = $googleUser['name']['familyName'] ? $googleUser['name']['familyName'] : $nameParts[1];
            $user = $userRepository->create(
                    [
                            'fullname'          => $googleUser->getName(),
                            'firstname'         => $firstName,
                            'lastname'          => $lastName,
                            'email'             => $googleUser->getEmail(),
                            'google_id'         => $googleUser->getId(),
                            'password'          => bcrypt($googleUser->getId()),
                            'register_source'   => 'google',
                            'google_avatar_img' => $googleUser->getAvatar()
                    ]);
        }
        Auth::login($user);
        return redirect()->intended($this->redirectPath());
    }
}