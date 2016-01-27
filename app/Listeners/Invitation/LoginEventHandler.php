<?php

namespace App\Listeners\Invitation;

use Illuminate\Auth\Events\Login;
use App\Models\Invitations\Repositories\InvitationRepository;

class LoginEventHandler
{
    public $inviteRepo = null;

    public function __construct(InvitationRepository $inviteRepository)
    {
        $this->inviteRepo = $inviteRepository;
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $userEmail = $event->user->getEmail();
        $invite = $this->inviteRepo->findBy('email', ['=' => $userEmail], ['status'])->first();
        if($invite){
            if ($invite->status == 0) {
                $this->inviteRepo->update(['status'=>1], $userEmail, 'email');
            }
        }
        return;
    }
}
