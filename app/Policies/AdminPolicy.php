<?php
//
//namespace App\Policies;
//
//use App\Models\Admin;
//use Illuminate\Auth\Access\HandlesAuthorization;
//use Illuminate\Auth\Access\Response;
//use Illuminate\Database\Eloquent\Model;
//
//class AdminPolicy
//{
//    use HandlesAuthorization;
//
//    /**
//     * Determine if the given post can be updated by the user.
//     *
//     * @param Model $model
//     *
//     * @return \Illuminate\Auth\Access\Response
//     */
//    public function isAdmin(Model $model) : Response
//    {
//        return $model::class === Admin::class
//            ? $this->allow()
//            : $this->deny('You do not own this request.');
//    }
//}
