<?php

namespace App\Models\Invitations\Repositories;

use App\Contracts\DoctrineRepository;
use App\Models\Invitations\Entities\Invitation as Invitation;

class InvitationRepository extends DoctrineRepository {
    public function getInvitationByEmail($email){
        return $this->getQueryBuilder()
                ->where('email', 'like', $email)
                ->first(['email']);
    }
}