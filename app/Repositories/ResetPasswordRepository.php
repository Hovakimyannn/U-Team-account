<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class ResetPasswordRepository
{
    /**
     * @var array|\Illuminate\Database\Eloquent\Model[]
     */
    protected array $models;

    /**
     * @param \Illuminate\Database\Eloquent\Model ...$models
     */
    public function __construct(Model ...$models)
    {
        $this->models = $models;
    }

    /**
     * @param string $email
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function findModelByEmail(string $email) : ?Model
    {
        foreach ($this->models as $model) {
            $model = $model->where('email', $email)->first();
            if($model != null){
                return $model;
            }
        }

        return null;
    }
}