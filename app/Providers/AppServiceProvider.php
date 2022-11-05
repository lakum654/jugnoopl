<?php

namespace App\Providers;

use App\Models\City;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        Paginator::defaultView('pagination.pagination');
        $city = City::where('status',1)->get();
        $country = ['India'];
        $common = ['city' => $city,'country' => $country];
        View::share($common);
    }
}
