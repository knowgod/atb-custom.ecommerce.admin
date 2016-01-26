<?php

use Illuminate\Database\Seeder;
use App\Models\Users\Repositories\UserRepository;
use App\Models\Users\Entities\User;

use App\Models\Acl\Entities\Role;


class RolesTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $superAdminRole = new Role();
        $superAdminRole->setName('SuperAdmin');
        $superAdminRole->setPermissions(['*']);
        $superAdminRole->save();

        $role = new Role();
        $role->setName('Store Manager');
        $role->setPermissions(["InvitationPolicy.index",
                "UserPolicy.index",
                "UserPolicy.create",
                "UserPolicy.update",
                "UserPolicy.delete",
                "OrderPolicy.index"]);
        $role->save();

        /**
         * @var $user App\Models\Users\Entities\User
         */

        $rep = EntityManager::getRepository(User::class);
        foreach ($rep->findAll() as $user){
            $user->grantRole($superAdminRole);
            $user->save();
        }
    }
}
