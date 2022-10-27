<?php

namespace App\Models;

use App\Models\Traits\AttributesModifier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 *  * @property mixed        $number
 *  * @property mixed        $parentId
 */
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
        'number'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function teachers() : MorphToMany
    {
        return $this->morphToMany(Teacher::class, 'teachable');
    }

    public function students() : BelongsToMany
    {
        return $this->belongsToMany(Student::class);
    }

    public function course() :BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
