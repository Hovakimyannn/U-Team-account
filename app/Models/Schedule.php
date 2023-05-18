<?php

namespace App\Models;

use App\Models\Traits\AttributesModifier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $name
 * @property string $size
 * @property string $extension
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
        'role',
        'name',
        'extension',
        'size'
    ];

    /**
     * @var string[]
     */
    protected $with = [
        'group',
        'course',
        'teacher',
    ];

    /**
     * @return BelongsTo
     */
    public function course() : BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * @return BelongsTo
     */
    public function group() : BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * @return BelongsTo
     */
    public function teacher() : BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'user_id');
    }
}
