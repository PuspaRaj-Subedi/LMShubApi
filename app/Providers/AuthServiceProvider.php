<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;
use Illuminate\Auth\Access\Response;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];
    /* define a admin user role */

    public function boot()
    {

        $this->registerPolicies();
        Gate::define('isAdmin', function($user) {
            return $user->role == 2
            ? Response::allow()
                : Response::deny('You must be an Admin !!.');
         });

         /* define a user role */
         Gate::define('isUser', function($user) {
             return $user->role == 3
             ? Response::allow()
             : Response::deny('You must be an User !!');
         });
        Passport::routes();
    }
}
