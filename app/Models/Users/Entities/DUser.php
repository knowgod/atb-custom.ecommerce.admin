<?php

namespace App\Models\Users\Entities;

use Doctrine\ORM\Mapping AS ORM;
use LaravelDoctrine\ORM\Auth\Authenticatable;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;


use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


/**
 * @ORM\Entity
 * @ORM\Table(name="dusers")
 */
class DUser implements
        AuthenticatableContract,
        AuthorizableContract,
        CanResetPasswordContract {
    use Authenticatable, Authorizable, CanResetPassword, Timestamps;

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
    public $email;

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

    public $google_avatar_img;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */

    protected $fullname;



    public function toJson($options = ''){
        if (!$options){
            $options = JSON_HEX_TAG | JSON_HEX_APOS;
        }
        return json_encode($this->jsonSerialize(), $options);
    }


}
