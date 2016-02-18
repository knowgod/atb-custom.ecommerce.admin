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

class OrderControllerTest extends TestCase {
    use DoctrineDatabaseTransactions,
            OperatesAsUser;

    /**
     * @var $OrderRepositoryMock Mockery\MockInterface
     */
    public $orderRepositoryMock;

    /**
     * @var Mock
     */
    protected $repo;

    public function setUp(){
        parent::setUp();
        $this->_prepareUserData();
    }

    public function test_order_index_action_binds_user_from_repository(){
        $this->call('GET', 'order/list');
        $this->assertResponseOk();
        $this->assertViewHas('collection');
    }


    public function test_ajax_requests_to_user_list_action_returns_valid_json(){
        $this->get('/order/list', ['HTTP_ACCEPT'       => 'application/json',
                                  'HTTP_CONTENT_TYPE' => 'application/json'])
                ->seeJsonStructure([
                        'collection' => [
                                'total',
                                'per_page',
                                'current_page',
                                'data' => [
                                        [
                                                'id',
                                                'increment_id',
                                                'grand_total',
                                                'customer_name',
                                                'email'
                                        ]
                                ]
                        ]
                ]);
    }
}