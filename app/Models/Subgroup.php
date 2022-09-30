<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static where(string $string, $number)
 */
class Subgroup extends Model
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
        'number',
    ];

    /**
     * @return BelongsToMany
     */
    public function course() : BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_group_subgroups');
    }

    /**
     * @return BelongsToMany
     */
    public function group(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'course_group_subgroups');
    }
}
