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
 *  * @property mixed        $firstName
 *  * @property mixed        $lastName
 *  * @property mixed        $patronymic
 *  * @property mixed        $email
 *  * @property mixed        $birthDate
 *
 */
class StudentInvitation extends Model
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

    public function institute() : BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }
}
