<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Invitations\Repositories\InvitationRepository as InvitationRepository;
use App\Models\Invitations\Entities\Invitation as Invitation;

class InvitationRepositoryTest extends TestCase
{

    public function fetchInvitationsByEmail()
    {
        // given
        factory(Invitation::class, 3)->create();

        // when
        $paginatedInvitations = InvitationRepository::getPaginatedInvitations(10);

        $emailOrderByDesc = InvitationRepository::orderBy('email', 'DESC');
        $emailOrderByAsc = InvitationRepository::orderBy('email', 'ASC');

        $createdAtOrderByDesc = InvitationRepository::orderBy('created_at', 'DESC');
        $createdAtOrderByAsc = InvitationRepository::orderBy('created_at', 'ASC');

        $updatedAtOrderByDesc = InvitationRepository::orderBy('updated_at', 'DESC');
        $updatedAtOrderByAsc = InvitationRepository::orderBy('updated_at', 'ASC');

        $statusOrderByDesc = InvitationRepository::orderBy('status', 'DESC');
        $statusOrderByAsc = InvitationRepository::orderBy('status', 'ASC');
        // then
    }


}
