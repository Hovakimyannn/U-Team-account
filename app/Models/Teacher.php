<?php

namespace App\Models;

use App\Enums\TeacherPositionEnum;
use App\Models\Traits\AttributesModifier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property string $firstName
 * @property string $lastName
 * @property string $patronymic
 * @property string $email
 * @property string $password
 * @property string $birthDate
 * @property TeacherPositionEnum $position
 */
class Teacher extends Authenticatable
{
    use
        HasApiTokens,
        HasFactory,
        Notifiable,
        AttributesModifier;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'patronymic',
        'email',
        'password',
        'birthDate',
        'position'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'position'          => TeacherPositionEnum::class,
    ];

    protected $with = [
        'courses',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function courses()
    {
        return $this->morphedByMany(Course::class, 'teachable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function groups()
    {
        return $this->morphedByMany(Group::class, 'teachable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department() : BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
