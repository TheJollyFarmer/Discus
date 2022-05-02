<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the user.
     *
     * @param  \App\User $user
     * @param  \App\User $signedInUser
     * @return mixed
     */
    public function view(User $user, User $signedInUser)
    {
        //
    }

    /**
     * Determine whether the user can create users.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param User       $signedInUser
     * @param  \App\User $user
     * @return mixed
     */
    public function update(User $signedInUser, User $user)
    {
        return $user->is($signedInUser);
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  \App\User $user
     * @param User       $signedInUser
     * @return mixed
     */
    public function delete(User $user, User $signedInUser)
    {
        //
    }
}
