<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Teacher extends Model
{
    use HasFactory;

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id'
    ];

    /**
     * @return BelongsToMany
     */
    public function fullCourseName() : BelongsToMany
    {
        return $this->belongsToMany(CourseGroupSubgroup::class, 'teacher_full_course_names', 'teacher_id', 'fullName_id');
    }
}
