<?php

namespace App\Policies;

use App\Repositories\Positions\Position;
use Illuminate\Auth\Access\HandlesAuthorization;

class PositionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the position.
     *
     * @param  \App\User  $user
     * @param  App\Repositories\Positions\Position  $position
     * @return mixed
     */
    public function view(User $user, Position $position = null)
    {
        return $user->hasAccess(['position.view']);
    }

    /**
     * Determine whether the user can create position
     *
     * @param  \App\User  $user
     * @param  App\Repositories\Positions\Position  $position
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAccess(['position.create']);
    }

    /**
     * Determine whether the user can update the position.
     *
     * @param  \App\User  $user
     * @param  App\Repositories\Positions\Position  $position
     * @return mixed
     */
    public function update(User $user, Position $position = null)
    {
        return $user->hasAccess(['position.update']);
    }

    /**
     * Determine whether the user can delete the position.
     *
     * @param  \App\User  $user
     * @param  App\Repositories\Positions\Position  $position
     * @return mixed
     */
    public function delete(User $user, Position $position = null)
    {
        return $user->hasAccess(['position.delete']);
    }
}
