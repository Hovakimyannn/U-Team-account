<?php

namespace App\Repositories;

use App\Models\Group;

class GroupRepository extends BaseRepository
{
    public function __construct(Group $model)
    {
        parent::__construct($model);
    }
}
