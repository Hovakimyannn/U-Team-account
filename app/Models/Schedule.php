<?php

namespace App\Models;

use App\Models\Traits\AttributesModifier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property string $role
 * @property integer $courseId
 * @property integer $groupId
 * @property integer $userId
 * @property string $path
 */
class Schedule extends Model
{
    use HasFactory,
        AttributesModifier;

    public $timestamps = true;

    protected $fillable = [
        'path',
        'role'
    ];
}
