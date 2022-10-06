<?php

namespace App\Models;

use App\Models\Traits\AttributesModifier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Group extends Model
{
<<<<<<< HEAD
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
=======
    use
        HasFactory,
        AttributesModifier;
>>>>>>> 9323ff065b1873e2e9f509a8b4b3159a5e623198
}
