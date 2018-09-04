<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
// use Illuminate\Database\Eloquent\Model;
use App\Repositories\Entity;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Laravel\Passport\HasApiTokens;
use App\Repositories\Users\FilterTrait;
use App\Repositories\Users\PresentationTrait;

class User extends Entity implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasApiTokens, FilterTrait, PresentationTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'avatar', 'password'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = app('hash')->make($value);
    }

    /**
     * Relationship with Role
     */
    public function roles()
    {
        return $this->belongsToMany(\App\Repositories\Roles\Role::class, 'role_users');
    }

    public function validateForPassportPasswordGrant($password)
    {
        if ($password == $this->password || app('hash')->check($password, $this->password)) {
            return true;
        }

        return false;
    }

    public function findForPassport($username)
    {
        if (stripos($username, '@')) {
            return $this->where('email', $username)->first();
        } else {
            return $this->where('phone', $username)->first();
        }
    }
}
