<?php

namespace App\Repositories\Users;

use App\User;

use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    /**
     * User model.
     * @var Model
     */
    protected $model;

    const STATUS_DISABLE = 0;
    const STATUS_ENABLE = 1;

    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }
}
