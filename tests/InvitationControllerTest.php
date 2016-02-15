<?php

use Mockery as M;
use App\Testing\DoctrineDatabaseTransactions;
use App\Testing\OperatesAsUser;

use App\Models\Invitations\Entities\Invitation;

class InvitationControllerTest extends TestCase {
    use DoctrineDatabaseTransactions,
        OperatesAsUser;

    /**
     * @var $invitationRepositoryMock Mockery\MockInterface
     */
    public $invitationRepositoryMock;

    public $invitation;

    /**
     * @var Mock
     */
    protected $repo;

    public function setUp(){
        parent::setUp();
        $this->_prepareUserData();

        $this->createAndSendInvitation();
    }

    protected function createAndSendInvitation()
    {
        $this->invitationEmail = 'someguy_invite_test@example.com';

        $this->post('/invitation/store',
            [
                'email' =>  $this->invitationEmail
            ]
        )->assertResponseStatus(302);

        return;
    }

    public function test_invitation_index_action_binds_user_from_repository(){
        $this->call('GET', 'invitation/list');
        $this->assertResponseOk();
        $this->assertViewHas('collection');
    }

    public function test_invitation_create_action_shows_invitation_create_form(){
        $this->visit('/invitation/create')->see('Invite User');
    }

    public function test_ajax_requests_to_invitation_list_action_returns_valid_json(){
        $this->get('/invitation/list', ['HTTP_ACCEPT'       => 'application/json',
            'HTTP_CONTENT_TYPE' => 'application/json'])
            ->seeJsonStructure([
                'collection' => [
                    'total',
                    'per_page',
                    'current_page',
                    'data' => [
                        [
                            'id',
                            'email',
                            'status',
                            'createdAt',
                            'updatedAt',

                        ]
                    ]
                ]
            ]);
    }

    public function test_invitation_exists_in_list()
    {
        $this->visit('/invitation/list')
            ->see($this->invitationEmail);
    }

    public function test_user_resend_invitation()
    {
        $this->seeInDatabase('invitations', ['email' => $this->invitationEmail]);
    }

    public function test_user_delete_invitation()
    {

    }

    public function tearDown()
    {
        parent::tearDown();
    }

}
