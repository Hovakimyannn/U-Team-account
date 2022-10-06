<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Group extends Model
{
    use HasFactory;

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * @return MorphMany
     */
    public function teacherCourse() : MorphMany
    {
        return $this->morphMany(TeacherCoursePivot::class, 'model');
    }
}
