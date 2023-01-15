<?php

namespace App\Repositories;

use App\Models\Institute;

class InstituteRepository extends BaseRepository
{
    public function __construct(Institute $model)
    {
        parent::__construct($model);
    }
}
