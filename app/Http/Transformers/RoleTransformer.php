<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Repositories\Roles\Role;

class RoleTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'users'
    ];

    public function transform(Role $role = null)
    {
        if (is_null($role)) {
            return [];
        }

        return [
            'id'          => hashid_encode($role->id),
            'name'        => $role->name,
            'slug'        => $role->slug,
            'permissions' => $role->permissions,
        ];
    }

    public function includeUsers(Role $role = null)
    {
        if (is_null($role)) {
            return $this->null();
        }
        return $this->collection($role->users, new UserTransformer);
    }
}
