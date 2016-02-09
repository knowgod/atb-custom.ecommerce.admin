<?php

use Mockery as M;
use App\Testing\DoctrineDatabaseTransactions;
use App\Testing\OperatesAsUser;

class InvitationControllerTest extends TestCase {
    use DoctrineDatabaseTransactions,
        OperatesAsUser;

    /**
     * @var $invitationRepositoryMock Mockery\MockInterface
     */
    public $invitationRepositoryMock;

    /**
     * @var Mock
     */
    protected $repo;

    public function setUp(){
        parent::setUp();
        $this->_prepareUserData();
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

    public function test_user_send_invitation()
    {
        $this->post('/invitation/store', ['email'=>'test.123konst1234@gmail.com'])->assertRedirectedTo('/invitation/list', ['message'=>'Invitation has been sent successfully!']);
        $this->seeInDatabase('invitations', ['email' => 'test.123konst1234@gmail.com', 'status'=>'0']);
    }

    public function test_user_resend_invitation()
    {
//        $this->get('/invitation/resend/id/5', ['id'=>'5'])->assertRedirectedTo('/invitation/list', ['message'=>'Invitation has been sent successfully!']);
//        $this->seeInDatabase('invitations', ['email' => 'test.123konst1234@gmail.com', 'status'=>'0']);
    }

    public function test_user_delete_invitation()
    {
        $this->get('/invitation/delete/id/3', ['id'=>'3'])->assertRedirectedTo('/invitation/list', ['message'=>'Invitation has been successfully removed']);
        $this->missingFromDatabase('invitations', ['email' => 'akostyantyn@gmail.com']);

    }
}
