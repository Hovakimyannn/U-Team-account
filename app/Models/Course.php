<?php

namespace App\Models;

use App\Models\Traits\AttributesModifier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @method static exists()
 */
class Course extends Model
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
        'name',
        'degree',
        'type'
    ];

    /**
     * @return MorphMany
     */
    public function teacherCourse() : MorphMany
    {
        return $this->morphMany(TeacherCoursePivot::class, 'model');
    }

    /**
     * @return BelongsTo
     */
    public function department() : BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
