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
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;



abstract class DoctrineModel implements Jsonable, JsonSerializable, Arrayable {

    protected $_em;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden = [];


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

    /**
     * Convert the model instance to JSON.
     *
     * @param  int $options
     * @return string
     */
    public function toJson($options = 0){
        if (!$options){
            $options = JSON_HEX_TAG | JSON_HEX_APOS;
        }
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize(){
        return $this->toArray();
    }

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray(){
        $objectProperties = get_object_vars($this);
        foreach($this->getHiddenFields() as $hiddenFieldName){
            if(isset($objectProperties[$hiddenFieldName]))
                unset($objectProperties[$hiddenFieldName]);
        }
        return $objectProperties;
    }

    protected function getEntityManager(){
        return $this->_em;
    }

    protected function getHiddenFields(){
        return $this->hidden;
    }

}