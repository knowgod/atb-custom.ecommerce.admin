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
use LaravelDoctrine\ACL\Contracts\Permission;
use App\Mappings as ACL;
use LaravelDoctrine\ACL\Contracts\Role as RoleContract;
use LaravelDoctrine\ACL\Permissions\HasPermissions;
use App\Mappings;

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
     * @ORM\Column(type="string", unique=true)
     */
    protected $name;

    /**
     * @ACL\HasAnnotatedPermissions
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

    /**
     * @return $this
     */

    public function setPermissions($permissions){
        $this->permissions = $permissions;
        return $this;
    }

    /**
     * @return string
     */
    public function setName($name){
        $this->name = $name;
        return $this;
    }

    public function toJson($options = 0)
    {
        if (!$options){
            $options = JSON_HEX_TAG | JSON_HEX_APOS;
        }

        $serializedData = $this->jsonSerialize();
        foreach ($serializedData['permissions'] as $element) {
            $permArr = explode('.', $element);
            if ($element == "*") {
                $serializedData['super_admin'] = true;
            } else {
                $serializedData['policies'][$permArr[0]][$permArr[1]] = true;
            }
        }

        return json_encode($serializedData, $options);
    }

}