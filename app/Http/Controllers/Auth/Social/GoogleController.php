<?php

/**
 * @category Atypicalbrands
 * Written by: vyatsyuk@atypicalbrands.com
 * Date: 30.12.15
 *
 */

namespace App\Http\Controllers\Auth\Social;

use App\Models\Users\Entities\User;
use App\Models\Users\Repositories\UserRepository;
use App\Models\Invitations\Repositories\InvitationRepository;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Auth;
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
    public function handleProviderCallback(UserRepository $userRepository, InvitationRepository $inviteRepository, User $userModel){

        $googleUser = Socialite::driver('google')->user();

        $user = $userRepository->findOneBy(array('email' => $googleUser->getEmail()));
        $inviteExist = $inviteRepository->findOneBy(array('email' => $googleUser->getEmail()));

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

            $user = $userModel->fillFromArray(
                    [
                            'email'             => $googleUser->getEmail(),
                            'firstname'         => $firstName,
                            'lastname'          => $lastName,
                            'fullname'          => $fullName,
                            'register_source'   => 'google',
                            'google_avatar_img' => $googleUser->getAvatar(),
                            'google_id'         => $googleUser->getId(),
                            'password'          => bcrypt($googleUser->getId())
                    ]
            );
            $user->save();
        }
        Auth::login($user);
        return redirect()->intended($this->redirectPath());
    }
}