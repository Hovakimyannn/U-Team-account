<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BaseRepository
{
    protected Model $model;

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Find single model by id.
     *
     * @param int  $id
     * @param bool $findOrFail
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function find(int $id, bool $findOrFail = true) : ?Model
    {
        return $findOrFail ?
            $this->model->newQuery()->findOrFail($id)
            : $this->model->newQuery()->find($id);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function findAll() : Collection
    {
        return $this->model->all();
    }
}
