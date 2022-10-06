<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function students() : BelongsToMany
    {
        return $this->belongsToMany(Student::class);
    }

    public function course() : BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
