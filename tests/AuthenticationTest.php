<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Testing\DoctrineDatabaseTransactions;

use App\Models\Users\Entities\User;

class AuthenticationTest extends TestCase {

    use DoctrineDatabaseTransactions;

    public $user;

    public function setUp()
    {
        parent::setUp();
        $this->createValidUser();
    }

    protected function createValidUser(){
        $user = new User();

        $user->setEmail('someguy@example.com')
                ->setFirstname('Seva')
                ->setLastname('Yatsyuk')
                ->setFullname('Seva'. ' ' . 'Yatsyuk')
                ->setRegisterSource('manual')
                ->setPassword(bcrypt('abcABC123'));
        $this->user = $user->save();
        return;
    }

    public function test_login_form_is_accessible(){
        $this->visit('/login')->see('Sign In');
    }

    public function test_dashboard_is_not_accessible_with_wrong_credentials(){
        $this->visit('/login')
                ->type('something_non_existing@gmail.com', 'email')
                ->type('sqweqwe', 'password')
                ->check('remember')
                ->press('Sign In')
                ->see('These credentials do not match our records.')
                ->dontSee('Dashboard');
    }

    public function test_dashboard_is_accessible_with_correct_credentials(){

        $this->visit('/login')
                ->type($this->user->getEmail(), 'email')
                ->type('abcABC123', 'password')
                ->check('remember')
                ->press('Sign In')
                ->seePageIs('/dashboard');
    }
}
