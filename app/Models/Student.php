<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Traits\AttributesModifier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @method static exists()
 */
class Student extends Authenticatable
{
    use
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

    public function groups() : BelongsToMany
    {
        return $this->belongsToMany(Group::class);
    }

    public function course() : BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function department() : BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
