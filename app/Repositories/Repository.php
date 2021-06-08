<?php


namespace App\Repositories;


abstract class Repository
{
    protected $model = false;

    public function get($select = '*', $where = FALSE){
        $builder = $this->model->select($select);
        return $builder;
    }

}
