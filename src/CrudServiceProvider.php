<?php

namespace Crud;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

class CrudServiceProvider extends ServiceProvider
{
    /**
     * The policies
     *
     * @var array
     */
    protected $policies = [
        //
    ];

    /**
     *
     */
    public function boot()
    {


    }

    /**
     *
     */
    public function register()
    {
        //
    }

    /**
     * Register the Permitlication's policies.
     *
     * @return void
     */
    public function registerPolicies()
    {
        //
    }


    public function provides()
    {
        //
    }

}
