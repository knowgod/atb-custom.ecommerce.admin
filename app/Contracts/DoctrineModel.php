<?php

/**
 * @category Atypicalbrands
 * Written by: vyatsyuk@atypicalbrands.com
 * Date: 18.01.16
 *
 */
namespace App\Contracts;

use LaravelDoctrine\ORM\Facades\EntityManager;
use LaravelDoctrine\ORM\Serializers;

abstract class DoctrineModel {

    use Serializers\Jsonable;

    protected $_em;


    public function save(){

        EntityManager::persist($this);
        EntityManager::flush();
        return $this;
    }

    public function remove(){
        EntityManager::remove($this);
        EntityManager::flush();
        return;
    }

    public function toJson($options = ''){
        if (!$options){
            $options = JSON_HEX_TAG | JSON_HEX_APOS;
        }
        return (new Serializers\JsonSerializer())->serialize($this, $options);
    }

    protected function getEntityManager(){
        return $this->_em;
    }


}