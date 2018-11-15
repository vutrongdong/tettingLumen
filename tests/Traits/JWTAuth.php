<?php
namespace Tests\Traits;
trait JWTAuth
{
    protected $headers = [];
    protected $user;
    protected function authWithSupperAdmin()
    {
        $this->user = factory(\App\User::class)->create([
            'name' => 'Supper admin',
            'email' => 'admin@nht.com',
            'password' => 'admin'
        ]);
        $role = factory(\App\Repositories\Roles\Role::class)->create([
            'name' => 'super_admin',
            'slug' => 'super_admin',
            'permissions' => ['admin.super-admin'=>true]
        ]);
        $this->user->roles()->sync([$role->id]);

        $this->auth();
    }
    protected function authWithAdminHasPermissions(array $permissions = [])
    {
        $permissions = array_merge(['admin'], $permissions);
        $this->user = factory(\App\User::class)->create([
            'name' => 'admin',
            'email' => 'admin@nht.com',
            'password' => 'admin'
        ]);
        $role = factory(\App\Repositories\Roles\Role::class)->create([
            'name' => 'admin',
            'slug' => 'admin',
            'permissions' => ['admin.admin'=>true]
        ]);
        $this->user->roles()->sync([$role->id]);
        $this->auth();
    }
    protected function authWithUserHasPermissions(array $user, array $permissions = [])
    {
        $permissions = array_merge(['admin.admin'], $permissions);
        $role = factory(\App\Repositories\Roles\Role::class)->create([
            'name' => 'user_editor',
            'slug' => 'user_editor',
            'permissions' => ['admin.user_editor'=>true]
        ]);
        $this->user->roles()->sync([$role->id]);
        $this->auth();
    }
    protected function auth()
    {
        // \Artisan::call('passport:install');
        $token = $this->user->createToken('TestToken')->accessToken;
        $this->headers['Accept'] = 'application/json';
        $this->headers['Content-Type'] = 'application/json';
        $this->headers['Authorization'] = 'Bearer ' . $token;
    }
}