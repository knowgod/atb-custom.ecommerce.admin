<?php

namespace App\Models\Invitations\Entities;
use App\Contracts\DoctrineModel;
use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;


/**
 * @ORM\Entity()
 */

class Invitation extends DoctrineModel {
    use Timestamps;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="integer")
     */

    public $status;

    /**
     * @return mixed
     */
    public function getEmail(){
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return Invitation
     */
    public function setEmail($email){
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus(){
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return Invitation
     */
    public function setStatus($status){
        $this->status = $status;
        return $this;
    }



}
