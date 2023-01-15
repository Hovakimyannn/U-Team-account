<?php

namespace App\Repositories;

use App\Models\Invitation;

class InvitationRepository extends BaseRepository
{
    public function __construct(Invitation $model)
    {
        parent::__construct($model);
    }
}
