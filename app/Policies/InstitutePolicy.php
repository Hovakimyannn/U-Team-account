<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Auth\User;

class InstitutePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
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
     * @param User $user
     *
     * @return \Illuminate\Auth\Access\Response
     */
    public function show(User $user) : Response
    {
        return $user::class === Admin::class ?
            $this->allow() :
            $this->deny('Don\'t allow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
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
     * @param User $user
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
     * @param User $user
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
     * Determine whether the user can get Departments the model.
     *
     * @param User $user
     *
     * @return \Illuminate\Auth\Access\Response
     */
    public function getDepartments(User $user) : Response
    {
        return $user::class === Admin::class ?
            $this->allow() :
            $this->deny('Don\'t allow');
    }
}
