<?php

/**
 * @category Atypicalbrands
 * Written by: vyatsyuk@atypicalbrands.com
 * Date: 21.01.16
 *
 */

namespace App\Models\Acl\Entities;

use App\Contracts\DoctrineModel;
use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\ACL\Mappings as ACL;
use LaravelDoctrine\ACL\Contracts\Role as RoleContract;
use LaravelDoctrine\ACL\Permissions\HasPermissions;

use App\Contracts\Entities;


/**
 * @ORM\Entity()
 */
class Role extends DoctrineModel implements RoleContract {

    use HasPermissions;
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ACL\HasPermissions
     */

     public $permissions;


    public function __construct(){

    }

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(){
        return $this->name;
    }
    /**
     * @return ArrayCollection|Permission[]
     */
    public function getPermissions(){
        return $this->permissions;
    }
}