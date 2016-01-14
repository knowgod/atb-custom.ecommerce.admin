<?php

/**
 * @category Atypicalbrands
 * Written by: vyatsyuk@atypicalbrands.com
 * Date: 05.01.16
 *
 */
namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;

abstract class Repository implements RepositoryInterface {
    /**
     * @var App
     */
    private $app;

    /**
     * @var
     */
    protected $model;

    /**
     * @var $query \Illuminate\Database\Eloquent\Builder
     */

    protected $query;

    /**
     * @param App $app
     */
    public function __construct(App $app){
        $this->app = $app;
        $this->initModel();
    }

    protected function initModel(){
        $model = $this->app->make($this->getModel());

        if (!$model instanceof Model){
            throw new Exception("Class {$this->getModel()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }
        $this->model = $model;
        $this->query = $model->newQuery();
        return;
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Builder
     *
     */

    protected function getQueryBuilder(){
        return $this->query;
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    abstract public function getModel();

    /**
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*')){
        return $this->getQueryBuilder()->get($columns);
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = array('*')){
        return $this->getQueryBuilder()->paginate($perPage, $columns);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data){
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */
    public function update(array $data, $id, $attribute = "id"){
        return $this->getQueryBuilder()->where($attribute, '=', $id)->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id){
        return $this->getQueryBuilder()->delete();
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*')){
        return $this->getQueryBuilder()->find($id, $columns);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function findOrFail($id, $columns = array('*')){
        return $this->getQueryBuilder()->findOrFail($id, $columns);
    }

    /**
     * @param $attribute
     * @param array $condition
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, array $condition, $columns = array('*')){
        $operator = current(array_keys($condition));
        $search = current(array_values($condition));

        return $this->getQueryBuilder()->where($attribute, $operator, $search);
    }

}
