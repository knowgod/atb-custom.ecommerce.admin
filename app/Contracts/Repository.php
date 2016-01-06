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
     * @param App $app
     */
    public function __construct(App $app){
        $this->app = $app;
        $this->createModel();
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Builder
     *
     */

    protected function createModel(){
        $model = $this->app->make($this->getModel());

        if (!$model instanceof Model){
            throw new Exception("Class {$this->getModel()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }
        return $this->model = $model->newQuery();
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
        $this->model->get($columns);
        return $this->model;
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = array('*')){
        $this->model->paginate($perPage, $columns);
        return $this->model;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data){
        $a =1;
        return $this->model->getModel()->create($data);
    }

    /**
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */
    public function update(array $data, $id, $attribute = "id"){
        return $this->model->where($attribute, '=', $id)->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id){
        return $this->model->destroy($id);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*')){
        return $this->model->find($id, $columns);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function findOrFail($id, $columns = array('*')){
        return $this->model->findOrFail($id, $columns);
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

        $this->model->where($attribute, $operator, $search)->get($columns);
        return $this->model;
    }

}
