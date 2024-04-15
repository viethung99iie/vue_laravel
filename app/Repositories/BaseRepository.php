<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use App\Models\Base;

/**
 * Class BaseService
 * @package App\Services
 */
class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct(
        Model $model
    ){
        $this->model = $model;
    }

    public function all(){
        return $this->model->all();
    }

    public function pagination(
        int $perpage = 20,
        array $conditions = [],
        array $fieldSearch,
        $relation){
        return $this->model
        ->keyword($conditions['keyword'] ?? null,$fieldSearch)
        ->publish(($conditions['publish']) ??  null)
        ->relationCount($relation)
        ->paginate($perpage);
    }

    // public function pagination(
    //     int $perpage = 20,
    // array $condition = [],
    //     array $fieldSearch = [],
    //     array $relation = [],
    //     array $extend = []

    // ){

    //     return $this->model
    //     ->keyword(($condition['keyword']) ?? null)
    //     ->publish(($condition['publish']) ??  null)
    //     ->relationCount($relation)
    //     ->orderBy($extend['orderBy'][0], $extend['orderBy'][1])
    //     ->paginate($perpage);
    // }


    public function create(array $payload = []){
        $model = $this->model->create($payload);
        return $model->fresh();
    }

    public function update(int $id = 0, array $payload = []){
        $model = $this->findById($id);
        $model->fill($payload);
        $model->save();
        return $model;
    }

    public function updateByIds(array $ids = [], $payload = []){
        return $this->model->whereIn('id', $ids)->update($payload);
    }

    public function findById(
        int $modelId,
        array $column = ['*'],
        array $relation = [],
    ){
        return $this->model->select($column)->with($relation)->findOrFail($modelId);
    }

    public function forceDeleteAll(array $ids = []){
        return $this->model->whereIn('id', $ids)->forceDelete();
    }

    public function forceDelete(int $id = 0){
        return $this->findById($id)->forceDelete();
    }

}

