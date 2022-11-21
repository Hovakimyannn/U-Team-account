<?php

namespace App\Repositories;

use App\Models\StudentInvitation;

class StudentInvitationRepository extends BaseRepository
{
    public function __construct(StudentInvitation $model)
    {
        parent::__construct($model);
    }
}
