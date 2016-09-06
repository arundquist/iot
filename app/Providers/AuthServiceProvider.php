<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->before(function ($user, $ability) {
            if ($user->admin) {
                return true;
            };
        });

        $gate->define('approved', function ($user) {
            return $user->approved;
        });

        $gate->define('admin', function ($user) {
            return $user->admin;
        });

        // non-admin users should only be able to edit machines that they "own"
        // That's determined by machines whose current 'code' is owned by
        // the current user

        $gate->define('allowedmachines', function($user, $machine){
            $machineids=$user->machines->pluck('id')->all();
          //  dd($machineids);
            return in_array($machine->id, $machineids);
        });
    }
}
