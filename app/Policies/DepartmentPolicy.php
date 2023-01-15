<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Department;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Auth\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     *
     * @return \Illuminate\Auth\Access\Response
     */
    public function index(User $user) : Response
    {
        return $user::class === Admin::class ?
            $this->allow() :
            $this->deny('Don\'t allow');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     *
     * @return \Illuminate\Auth\Access\Response
     */
    public function show() : Response
    {
        return $this->allow();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
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
     * @param  \Illuminate\Foundation\Auth\User  $user
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
     * @param  \Illuminate\Foundation\Auth\User  $user
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
     * Determine whether the user can restore the model.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     *
     * @return \Illuminate\Auth\Access\Response
     */
    public function getCourses(User $user) : Response
    {
        return $this->allow();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     *
     * @return \Illuminate\Auth\Access\Response
     */
    public function getTeachers(User $user) : Response
    {
        return $this->allow();
    }
}
