<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class generateJWT extends ServiceProvider
{
    // SE AGREGA LA RUTA DEL HELPER
    public function register()
    {
        require_once app_path() . '/helpers/generateJWT.php';
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
