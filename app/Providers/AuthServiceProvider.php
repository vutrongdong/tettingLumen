<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\ServiceProvider;
use Dusterio\LumenPassport\LumenPassport;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\User::class => \App\Policies\UserPolicy::class,
        \App\Repositories\Roles\Role::class => \App\Policies\RolePolicy::class,
        \App\Repositories\Positions\Position::class => \App\Policies\PositionPolicy::class,
    ];

    /**
     * Register the application's policies.
     *
     * @return void
     */
    public function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    /**
     * Get the policies defined on the provider.
     *
     * @return array
     */
    public function policies()
    {
        return $this->policies;
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register passport
     * @return void
     */
    private function registerPassport()
    {
        LumenPassport::routes($this->app);
        LumenPassport::tokensExpireIn(\Carbon\Carbon::now()->addYears(1));
    }

    /**
     * Register gates
     * @return void
     */
    private function registerGates()
    {
        // user
        Gate::define('user.view', 'App\Policies\UserPolicy@view');
        Gate::define('user.create', 'App\Policies\UserPolicy@create');
        Gate::define('user.update', 'App\Policies\UserPolicy@update');
        Gate::define('user.delete', 'App\Policies\UserPolicy@delete');
        // role gate
        Gate::define('role.view', 'App\Policies\RolePolicy@view');
        Gate::define('role.create', 'App\Policies\RolePolicy@create');
        Gate::define('role.update', 'App\Policies\RolePolicy@update');
        Gate::define('role.delete', 'App\Policies\RolePolicy@delete');
        // position gate
        Gate::define('position.view', 'App\Policies\PositionPolicy@view');
        Gate::define('position.create', 'App\Policies\PositionPolicy@create');
        Gate::define('position.update', 'App\Policies\PositionPolicy@update');
        Gate::define('position.delete', 'App\Policies\PositionPolicy@delete');
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {

        $this->registerPassport();
        $this->registerPolicies();
        $this->registerGates();
    }
}
