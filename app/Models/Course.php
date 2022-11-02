<?php

namespace App\Models;

use App\Enums\CourseDegreeEnum;
use App\Enums\CourseTypeEnum;
use App\Models\Traits\AttributesModifier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;


/**
 * @method static exists()
 *
 *  * @property mixed $number
 *  * @property mixed $degree
 *  * @property mixed $type
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
        'number',
        'degree',
        'type'
    ];

    protected $casts = [
        'degree' => CourseDegreeEnum::class,
        'type'   => CourseTypeEnum::class,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function teachers() : MorphToMany
    {
        return $this->morphToMany(Teacher::class, 'teachable');
    }

    /**
     * @return BelongsTo
     */
    public function department() : BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
