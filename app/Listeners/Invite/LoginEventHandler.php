<?php

namespace App\Listeners\Invite;

use Illuminate\Auth\Events\Login;
use App\Models\Invitations\Repositories\InviteRepository;

class LoginEventHandler
{
    public $inviteRepo = null;

    public function __construct(InviteRepository $inviteRepository)
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
