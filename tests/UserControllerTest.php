<?php

/**
 * @category Atypicalbrands
 * Written by: vyatsyuk@atypicalbrands.com
 * Date: 29.01.16
 *
 */

use Mockery as M;
use App\Testing\DoctrineDatabaseTransactions;
use App\Testing\OperatesAsUser;

class UserControllerTest extends TestCase {
    use DoctrineDatabaseTransactions,
            OperatesAsUser;

    /**
     * @var $userRepositoryMock Mockery\MockInterface
     */
    public $userRepositoryMock;

    /**
     * @var Mock
     */
    protected $repo;


    public $user;

    public function setUp(){
        parent::setUp();
        $this->_prepareUserData();
    }

    public function test_user_index_action_binds_user_from_repository(){
        $this->call('GET', 'user/list');
        $this->assertResponseOk();
        $this->assertViewHas('collection');
    }

    public function test_user_create_action_shows_user_create_form(){
        $this->visit('/user/create')->see('Create User');
    }

    public function test_user_update_action_shows_user_update_form_with_user_data(){
        $this->visit('/user/update/id/' . $this->user->getId())->see($this->user->getEmail());
    }

    public function test_ajax_requests_to_user_list_action_returns_valid_json(){

        $this->get('/user/list', ['HTTP_ACCEPT'       => 'application/json',
                                  'HTTP_CONTENT_TYPE' => 'application/json'])
                ->seeJsonStructure([
                        'collection' => [
                                'total',
                                'per_page',
                                'current_page',
                                'data' => [
                                        [
                                                'id',
                                                'firstname',
                                                'lastname',
                                                'email'
                                        ]
                                ]
                        ]
                ]);
    }

    public function test_user_can_be_created_via_ajax_request(){
        $this->post('user/create',
                ['email'                 => "user@someuser.com",
                 'firstname'             => "SomeUser",
                 'lastname'              => "SomeLastname",
                 'password'              => "1111111",
                 'password_confirmation' => "1111111"]
        )->assertResponseStatus(302);
    }
}