<?php

namespace App\Models;

use App\Models\Traits\AttributesModifier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use
        HasFactory,
        AttributesModifier;

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'institute_id'
    ];

    /**
     * @return BelongsTo
     */
    public function institute() :BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }

    /**
     * @return HasMany
     */
    public function courses() : HasMany
    {
        return $this->hasMany(Course::class);
    }
}
