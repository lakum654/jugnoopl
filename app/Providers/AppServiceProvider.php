<?php

namespace App\Providers;

use App\Models\City;
use App\Models\Order;
use App\Models\Po;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\SupplierProduct;
use App\Models\Warehouse;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
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

        $totalOrder = Order::count();
        $totalWarehouse = Warehouse::count();
        $totalPO = Po::count();
        $totalSupplier = Supplier::count();
        $totalProduct = Product::count();

        $common = ['city' => $city,'country' => $country,'totalOrder' => $totalOrder,'totalWarehouse' => $totalWarehouse,'totalPO' => $totalPO,'totalSupplier' => $totalSupplier,'totalProduct' => $totalProduct];
        View::share($common);
    }
}
