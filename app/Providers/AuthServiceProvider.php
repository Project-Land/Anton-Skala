<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Opcodes\LogViewer\Facades\LogViewer;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        LogViewer::auth(function ($request) {
            return $request->user()
                && in_array($request->user()->role_id, [1]);
        });
    }
}
