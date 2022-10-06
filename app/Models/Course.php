<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    public function department() : BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function students() : HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function groups() : HasMany
    {
        return $this->hasMany(Course::class);
    }
}
