<?php

/**
 * @category Atypicalbrands
 * Written by: vyatsyuk@atypicalbrands.com
 * Date: 18.01.16
 *
 */

namespace App\Contracts;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\PersistentCollection;
use LaravelDoctrine\ORM\Serializers;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

abstract class DoctrineModel implements Jsonable, JsonSerializable, Arrayable {

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     *
     */

    protected $_em;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden = [];

    public function __construct(EntityManagerInterface $em){
        $this->_em = $em;
        $this->_init();
    }


    public function save(){
        $this->getEntityManager()->persist($this);
        $this->getEntityManager()->flush();
        return $this;
    }

    public function remove(){
        $this->getEntityManager()->remove($this);
        $this->getEntityManager()->flush();
        return;
    }

    public function fillFromArray(array $attributes = []){
        $this->fill($attributes);
        return $this;
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
        foreach ($this->getHiddenFields() as $hiddenFieldName){
            if (isset($objectProperties[$hiddenFieldName]))
                unset($objectProperties[$hiddenFieldName]);
        }
        return array_merge($objectProperties, $this->relationsToArray());
    }

    /**
     * Get the model's relationships in array form.
     *
     * @return array
     */
    public function relationsToArray(){
        $attributes = [];
        $objectProperties = get_object_vars($this);

        foreach ($this->getHiddenFields() as $hiddenFieldName){
            if (isset($objectProperties[$hiddenFieldName]))
                unset($objectProperties[$hiddenFieldName]);
        }

        foreach ($objectProperties as $key => $value){
            if ($value instanceof Arrayable || $value instanceof PersistentCollection){
                $relation = $value->toArray();
                $attributes[$key] = $relation;
            }
            if (isset($relation)){
                unset($relation);
            }
        }

        return $attributes;
    }

    /**
     * @return EntityManagerInterface
     *
     */

    public function getEntityManager(){
        return ($this->_em) ? $this->_em : app('em');
    }

    /**
     * @return array
     */

    protected function getHiddenFields(){
        $propsHiddenByDefault = ['hidden', '_em'];
        return array_merge($this->hidden, $propsHiddenByDefault);
    }

    protected function _init(){
        return;
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public function getRepository(){
        return $this->getEntityManager()->getRepository(get_class($this));
    }

    public function fill(array $attributes){
        foreach ($attributes as $key => $value){
            if (property_exists($this, $key)){
                $this->{$key} = $value;
            }
        }
    }
}