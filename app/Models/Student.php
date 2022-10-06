<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    use HasFactory;
    
    public $timestamps = true;

    protected $fillable = [
        'first_name',
        'last_name',
        'patronymic',
        'birth_date',
        'email',
        'password'
    ];

    public function course() : BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function groups() : BelongsToMany
    {
        return $this->belongsToMany(Group::class);
    }
}
