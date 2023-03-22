<?php

namespace App\Repositories;

use App\Models\Schedule;

class ScheduleRepository extends BaseRepository
{
    public function __construct(Schedule $model)
    {
        parent::__construct($model);
    }
}
