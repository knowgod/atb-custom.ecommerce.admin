<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Invitations\Repositories\InviteRepository as InviteRepo;
use App\Models\Invitations\Entities\Invite as Invite;

class InviteRepositoryTest extends TestCase
{

    public function fetchInvitationsByEmail()
    {
        // given
        factory(InviteRepo::class, 3)->create();

        // when
        $paginatedInvitations = InviteRepo::getPaginatedInvitations(10);

        $emailOrderByDesc = InviteRepo::orderBy('email', 'DESC');
        $emailOrderByAsc = InviteRepo::orderBy('email', 'ASC');

        $createdAtOrderByDesc = InviteRepo::orderBy('created_at', 'DESC');
        $createdAtOrderByAsc = InviteRepo::orderBy('created_at', 'ASC');

        $updatedAtOrderByDesc = InviteRepo::orderBy('updated_at', 'DESC');
        $updatedAtOrderByAsc = InviteRepo::orderBy('updated_at', 'ASC');

        $statusOrderByDesc = InviteRepo::orderBy('status', 'DESC');
        $statusOrderByAsc = InviteRepo::orderBy('status', 'ASC');



        // then
    }


}
