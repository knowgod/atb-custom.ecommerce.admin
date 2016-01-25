<?php

namespace App\Models\Users\Entities;

use App\Contracts\DoctrineModel;
use App\Models\Acl\Entities\Role;
use Doctrine\ORM\Mapping AS ORM;

use LaravelDoctrine\ACL\Contracts\HasPermissions as HasPermissionsContract;
use LaravelDoctrine\ORM\Auth\Authenticatable;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use LaravelDoctrine\ACL\Roles\HasRoles;

use LaravelDoctrine\ACL\Mappings as ACL;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use LaravelDoctrine\ACL\Contracts\HasRoles as HasRolesContract;
use LaravelDoctrine\ACL\Permissions\HasPermissions;



/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends DoctrineModel implements
        AuthenticatableContract,
        AuthorizableContract,
        CanResetPasswordContract,
        HasRolesContract
    {
    use Authenticatable, Authorizable, CanResetPassword, Timestamps, HasRoles, HasPermissions;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $lastname;

    /**
     * @ORM\Column(type="string", length=32, nullable=false, unique=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */

    protected $register_source;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */

    protected $google_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */

    protected $google_avatar_img;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */

    protected $fullname;

    /**
     * @ACL\HasRoles()
     * @var \Doctrine\Common\Collections\ArrayCollection|\LaravelDoctrine\ACL\Contracts\Role[]
     */
    protected $roles;

    protected $hidden = ['password'];

    /**
     * @return mixed
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return User
     */
    public function setId($id){
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstname(){
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     * @return User
     */
    public function setFirstname($firstname){
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastname(){
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     * @return User
     */
    public function setLastname($lastname){
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail(){
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return User
     */
    public function setEmail($email){
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRegisterSource(){
        return $this->register_source;
    }

    /**
     * @param mixed $register_source
     * @return User
     */
    public function setRegisterSource($register_source){
        $this->register_source = $register_source;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGoogleId(){
        return $this->google_id;
    }

    /**
     * @param mixed $google_id
     * @return User
     */
    public function setGoogleId($google_id){
        $this->google_id = $google_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGoogleAvatarImg(){
        return $this->google_avatar_img;
    }

    /**
     * @param mixed $google_avatar_img
     * @return User
     */
    public function setGoogleAvatarImg($google_avatar_img){
        $this->google_avatar_img = $google_avatar_img;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFullname(){
        return $this->fullname;
    }

    /**
     * @param mixed $fullname
     * @return User
     */
    public function setFullname($fullname){
        $this->fullname = $fullname;
        return $this;
    }

    /**
     * @return mixed
     */

    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param Role $role
     * @return $this
     */

    public function grantRole(Role $role)
    {
        $this->roles[] = $role;
        return $this;
    }

    public function revokeRole(Role $role)
    {
        if($this->hasRole($role)){
            //remove it here
        }
        return $this;
    }

}
