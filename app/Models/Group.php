<?php

namespace App\Models;

use App\Models\Traits\AttributesModifier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property int $number
 * @property int $parentId
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

    /**
     * @return BelongsToMany
     */
    public function students() : BelongsToMany
    {
        return $this->belongsToMany(Student::class);
    }

    /**
     * @return BelongsTo
     */
    public function course() : BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * @return HasMany
     */
    public function children() : HasMany
    {
        return $this->hasMany(Group::class, 'parent_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function parent() : HasOne
    {
        return $this->hasOne(Group::class, 'parent_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
