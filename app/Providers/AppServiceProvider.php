<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
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
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Gagana lang ang forceScheme('https') kung ang kasalukuyang 
         * gamit na link ay galing sa ngrok. Kapag localhost ang gamit mo,
         * hahayaan lang niya itong naka-HTTP para hindi ka mag-error.
         */
        if (str_contains(request()->getHost(), 'ngrok-free.dev')) {
            URL::forceScheme('https');
        }

        // For Tailwind CSS pagination styles
        Paginator::useTailwind();
    }
}