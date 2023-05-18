<?php

namespace App\Models;

use App\Models\Traits\AttributesModifier;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @method static exists()
 *
 * @property string $firstName
 * @property string $lastName
 * @property string $patronymic
 * @property string $email
 * @property string $password
 * @property string $birthDate
 * @property string $avatar
 * @property string $thumbnail
 */
class Student extends Authenticatable
{
    use
        HasFactory,
        Notifiable,
        MustVerifyEmail,
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
        'avatar',
        'thumbnail',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'department_id',
        'course_id',
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
    ];

    protected $with = [
        'groups',
        'course',
    ];

    /**
     * @return BelongsToMany
     */
    public function groups() : BelongsToMany
    {
        return $this->belongsToMany(Group::class);
    }

    /**
     * @return BelongsTo
     */
    public function course() : BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * @return BelongsTo
     */
    public function department() : BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function thumbnail(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('storage/avatar/thumbnail/'.$value),
        );
    }
}
