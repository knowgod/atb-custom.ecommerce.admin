<?php

/**
 * @category Atypicalbrands
 * Written by: vyatsyuk@atypicalbrands.com
 * Date: 29.01.16
 *
 */

namespace App\Testing;
use App\Models\Users\Entities\User;
use Doctrine\ORM\EntityManager;

trait OperatesAsUser
{
    public $user;

    protected function _prepareUserData(){
        $user = new User();
        $user->setEmail('someguy@example.com')
                ->setFirstname('Seva')
                ->setLastname('Yatsyuk')
                ->setFullname('Seva' . ' ' . 'Yatsyuk')
                ->setRegisterSource('manual')
                ->setPassword(bcrypt('abcABC123'));

        $rolesRepo = $this->app->em->getRepository(\App\Models\Acl\Entities\Role::class);
        $superAdminRole = $rolesRepo->findOneBy(array('name' => 'SuperAdmin'));
        $user->grantRole($superAdminRole);
        $this->user = $user->save();
        $this->be($this->user);
    }

}
