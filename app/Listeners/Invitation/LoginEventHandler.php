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

        $invite = $this->inviteRepo->findOneBy(array('email' => $userEmail));

        if($invite){
            if ($invite->status == 0) {
                $invite->setStatus(1)->save();
            }
        }
        return;
    }
}
