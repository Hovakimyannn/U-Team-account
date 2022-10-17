<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
    /**
     * @param int  $id
     * @param bool $findOrFail
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function find(int $id, bool $findOrFail = true) : ?Model;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function findAll() : Collection;

    /**
     * @return array
     */
    public function getUserData() : array;
}
