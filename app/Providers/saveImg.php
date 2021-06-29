<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class saveImg extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        require_once app_path() . '/helpers/saveImg.php';
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
