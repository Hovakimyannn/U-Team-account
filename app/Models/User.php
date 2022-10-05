<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property mixed        $name
 * @property mixed        $email
 * @property mixed|string $password
 * @property mixed        $firstName
 * @property mixed        $lastName
 * @property mixed        $fatherName
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;
    public $timestamps = true;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'fatherName',
        'email',
        'password',
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
    ];

    public function role() : BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function assignRole($role) : void
    {
        $this->role()->associate((new Role)->getRoleByName($role));
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function assignDepartment($department) :void
    {
        $this->department()->associate((new Department)->getDepartmentByName($department));
    }

    /**
     * @return BelongsToMany
     */
    public function student() : BelongsToMany
    {
        return $this->belongsToMany(Student::class);
    }

    /**
     * @return BelongsToMany
     */
    public function fullCourseName() : BelongsToMany
    {
        return $this->belongsToMany(CourseGroupSubgroup::class, 'students', 'user_id', 'fullCourseName_id');
    }

    /**
     * @return HasOne
     */
    public function teacher() :HasOne
    {
        return $this->hasOne(Teacher::class, 'user_id');
    }
}
