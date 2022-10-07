<?php

namespace App\Models;

use App\Models\Traits\AttributesModifier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Group extends Model
{
    use
        HasFactory,
        AttributesModifier;

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
