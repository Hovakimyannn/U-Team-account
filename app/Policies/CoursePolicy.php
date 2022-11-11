<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Student;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Auth\User;

class CoursePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \Illuminate\Foundation\Auth\User $user
     *
     * @return \Illuminate\Auth\Access\Response
     */
    public function index(User $user) : Response
    {
        return $user::class !== Student::class ?
            $this->allow() :
            $this->deny('Don\'t allow');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \Illuminate\Foundation\Auth\User $user
     *
     * @return \Illuminate\Auth\Access\Response
     */
    public function show(User $user) : Response
    {
        return $user::class !== Student::class ?
            $this->allow() :
            $this->deny('Don\'t allow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \Illuminate\Foundation\Auth\User $user
     *
     * @return \Illuminate\Auth\Access\Response
     */
    public function create(User $user) : Response
    {
        return $user::class === Admin::class ?
            $this->allow() :
            $this->deny('Don\'t allow');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \Illuminate\Foundation\Auth\User $user
     *
     * @return \Illuminate\Auth\Access\Response
     */
    public function update(User $user) : Response
    {
        return $user::class === Admin::class ?
            $this->allow() :
            $this->deny('Don\'t allow');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \Illuminate\Foundation\Auth\User $user
     *
     * @return \Illuminate\Auth\Access\Response
     */
    public function destroy(User $user) : Response
    {
        return $user::class === Admin::class ?
            $this->allow() :
            $this->deny('Don\'t allow');
    }

    /**
     *
     * @param \Illuminate\Foundation\Auth\User $user
     *
     * @return \Illuminate\Auth\Access\Response
     */
    public function getGroups(User $user) : Response
    {
        return $this->allow();
    }

    /**
     *
     * @param \Illuminate\Foundation\Auth\User $user
     *
     * @return \Illuminate\Auth\Access\Response
     */
    public function getStudents(User $user) : Response
    {
        return $this->allow();
    }

    /**
     *
     * @param \Illuminate\Foundation\Auth\User $user
     *
     * @return \Illuminate\Auth\Access\Response
     */
    public function getTeachers(User $user) : Response
    {
        $this->allow();
    }
}
