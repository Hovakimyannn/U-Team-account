<?php

namespace App\Models;

use App\Models\Traits\AttributesModifier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;

/**
 * @method static exists()
 *
 * @property string $firstName
 * @property string $lastName
 * @property string $patronymic
 * @property string $email
 * @property string $birthDate
 * @property string $password
 * @property int    $instituteId
 * @property int    $departmentId
 * @property int    $courseId
 * @property int    $groupId
 * @property string $token
 * @property string $role
 * @property string $payload
 *
 */
class Invitation extends Model
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
        'birthDate'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'department_id',
        'course_id',
        'group_id',
        'subgroup_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function institute() : BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }
}
