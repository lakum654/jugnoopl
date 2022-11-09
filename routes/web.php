<?php

//for admin
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Admin\PoController as Po;
use App\Http\Controllers\LoginController as Login;
use App\Http\Controllers\Admin\CityController as City;
use App\Http\Controllers\Admin\UnitController as Unit;
use App\Http\Controllers\Admin\UserController as User;
use App\Http\Controllers\Supplier\PoController as SPO;
use App\Http\Controllers\User\Warehouse\GRNController;
use App\Http\Controllers\Warehouse\PoController as WPO;
use App\Http\Controllers\Admin\BrandController as Brand;
use App\Http\Controllers\User\Shopkeeper\OrderController;
use App\Http\Controllers\User\PoPriceController as POPrice;
use App\Http\Controllers\Admin\ProductController as Product;
use App\Http\Controllers\Admin\ProfileController as Profile;

//for User
use App\Http\Controllers\User\ProfileController as UProfile;
use App\Http\Controllers\User\PoReportController as PoReport;
use App\Http\Controllers\Admin\CategoryController as Category;
use App\Http\Controllers\Admin\SupplierController as Supplier;
use App\Http\Controllers\User\Shopkeeper\PoController as ShoPO;
use App\Http\Controllers\Admin\DashboardController as Dashboard;
use App\Http\Controllers\Admin\WarehouseController as Warehouse;
use App\Http\Controllers\Supplier\PoPriceController as SPOPrice;
use App\Http\Controllers\Supplier\ProductController as SProduct;
use App\Http\Controllers\Supplier\ProfileController as SProfile;
use App\Http\Controllers\Warehouse\PoPriceController as WPOPrice;

//for suppler
use App\Http\Controllers\Warehouse\ProfileController as WProfile;
use App\Http\Controllers\Admin\ShopkeeperController as Shopkeeper;
use App\Http\Controllers\User\Supplier\PoController as SupplierPO;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\Admin\SubCategoryController as SubCategory;

//for warehouse
use App\Http\Controllers\Shopkeeper\ProfileController as ShoProfile;
use App\Http\Controllers\User\Warehouse\PoController as WarehousePO;
use App\Http\Controllers\User\Shopkeeper\OrderController as shoOrder;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

//for Shopkeeper
use App\Http\Controllers\User\Supplier\ProductController as SuppProduct;
use App\Http\Controllers\Supplier\DashboardController as SupplierDashboard;



use App\Http\Controllers\Admin\SupplierProductController as SupplierProduct;
use App\Http\Controllers\Warehouse\DashboardController as WarehouseDashboard;
use App\Http\Controllers\User\Warehouse\ProductController as WarehouseProduct;
use App\Http\Controllers\Shopkeeper\DashboardController as ShopkeeperDashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('optimize', function () {
    return "Done";
});
// Auth::routes();

Route::get('/', [Login::class, 'index'])->middleware('checkLogin');
Route::post('login', [Login::class, 'login'])->middleware('checkLogin');

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {

    Route::get('logout', [Login::class, 'logout']);

    Route::get('dashboard', [Dashboard::class, 'index']);
    Route::controller(Dashboard::class)->group(function () {
        Route::get('order-detail/{id}', 'orderDetail');
        Route::get('warehouse-detail/{id}', 'warehouseDetail');
        Route::get('po-detail/{id}', 'poDetail');
    });

    Route::resource('profile', Profile::class);

    Route::resource('user', User::class);

    Route::resource('shopkeeper', Shopkeeper::class);

    Route::resource('supplier', Supplier::class);

    Route::resource('supplier-product', SupplierProduct::class);
    Route::controller(SupplierProduct::class)->group(function () {
        Route::get('get-supplier-product/{id}', 'getSupplierProduct');
        Route::get('get-supplier/{id}', 'getSupplier');
    });

    Route::resource('warehouse', Warehouse::class);
    Route::controller(Warehouse::class)->group(function () {
        Route::get('warehouse-stock', 'warehouseStock');
    });

    Route::resource('city', City::class);
    Route::resource('unit', Unit::class);
    Route::resource('brand', Brand::class);
    Route::resource('category', Category::class);
    Route::resource('sub_category', SubCategory::class);
    Route::resource('product', Product::class);

    Route::post('assign-product', [Product::class, 'assignProduct']);

    Route::controller(Po::class)->group(function () {
        Route::get('po/create', 'create');
        Route::post('po/save', 'store');
        Route::get('po/{type}', 'index')->whereIn('type', ['requested', 'in-progress', 'received']);
    });
    Route::resource('po', Po::class);

    Route::post('orders/status', [AdminOrderController::class, 'changeStatus']);
    Route::post('orders', [AdminOrderController::class, 'startDelivery']);
    Route::get('orders_list',[AdminOrderController::class,'index'])->name('order.index');
    Route::post('order/get_warehouse',[AdminOrderController::class,'getWarehouses'])->name('order.get_warehouse');
});


//route for supplier
Route::group(['prefix' => 'user', 'middleware' => 'user'], function () {

    Route::resource('u-dashboard', UserDashboard::class);
    Route::resource('supp-product', SuppProduct::class);
    Route::resource('u-profile', UProfile::class);

    //for only supplier
    Route::resource('supplier-po', SupplierPO::class);
    Route::controller(SupplierPO::class)->group(function () {
        Route::post('supplier-save-item', 'saveItem');
    });

    Route::controller(Dashboard::class)->group(function () {
        Route::get('order-detail/{id}', 'orderDetail');
        Route::get('warehouse-detail/{id}', 'warehouseDetail');
        Route::get('po-detail/{id}', 'poDetail');
    });

    Route::post('orders', [AdminOrderController::class, 'startDelivery']);

    //for only warehosue
    Route::controller(WarehousePO::class)->group(function () {
        // Route::post('warehouse-save-item', 'saveItem');
        Route::get('view-item/{id}', 'viewItem');
        Route::get('w-po/{type}', 'index')->whereIn('type', ['requested', 'in-progress', 'received']);
    });
    Route::resource('w-po', WarehousePO::class);

    Route::controller(GRNController::class)->group(function () {
        Route::get('grn-po/{id}', 'GRNPO');
        Route::post('w-update-po-item', 'updatePOItem');
    });
    Route::resource('grn', GRNController::class);

    Route::resource('warehouse-product', WarehouseProduct::class);
    Route::controller(WarehouseProduct::class)->group(function(){
          Route::get('search-product', 'searchProduct');
          Route::post('transfer-product','transferProduct');
    });
    //end warehouse


    //start for shopkeeper
    Route::controller(shoOrder::class)->group(function () {
    });
    Route::resource('sho-order', shoOrder::class);
    //end for shopkeeper


    Route::resource('po-price', POPrice::class);

    Route::resource('po-report', PoReport::class);
});


//route for supplier
// Route::group(['prefix' => 'supplier', 'middleware' => 'supplier'], function () {

//     // Route::get('dashboard', [Dashboard::class, 'index']);
//     Route::resource('s-dashboard', SupplierDashboard::class);
//     Route::resource('s-product', SProduct::class);
//     Route::resource('s-profile', SProfile::class);

//     Route::resource('s-po', SPO::class);
//     Route::controller(SPO::class)->group(function () {
//         Route::post('save-item', 'saveItem');
//     });

//     Route::resource('s-po-price', SPOPrice::class);
// });


//route for warehouse
// Route::group(['prefix' => 'warehouse', 'middleware' => 'warehouse'], function () {

//     Route::resource('w-dashboard', WarehouseDashboard::class);
//     Route::resource('w-profile', WProfile::class);

//     Route::controller(WPO::class)->group(function () {
//         Route::post('save-item', 'saveItem');
//         Route::get('view-item/{id}', 'viewItem');
//         // Route::post('save-grn', 'saveGRN');
//         // Route::post('save-grn-item', 'saveGRNItem');
//         Route::get('w-po/{type}', 'index')->whereIn('type', ['requested', 'in-progress', 'received']);
//     });
//     Route::resource('w-po', WPO::class);

//     Route::controller(GRNController::class)->group(function () {
//         Route::get('grn-po/{id}', 'GRNPO');
//         Route::post('update-po-item', 'updatePOItem');
//     });
//     Route::resource('grn', GRNController::class);

//     Route::resource('w-po-price', WPOPrice::class);
// });


//route for shopkeeper
// Route::group(['prefix' => 'shopkeeper', 'middleware' => 'shopkeeper'], function () {

//     Route::resource('sho-dashboard', ShopkeeperDashboard::class);
//     Route::resource('sho-profile', ShoProfile::class);

//     Route::controller(ShoPO::class)->group(function () {
//         Route::get('sho-get-supplier-product/{id}', 'getSupplierProduct');
//         Route::get('sho-get-supplier/{id}', 'getSupplier');
//         Route::get('sho-po/create', 'create');
//         Route::get('sho-po/{type}', 'index')->whereIn('type', ['requested', 'in-progress', 'received']);
//     });
//     Route::resource('sho-po', ShoPO::class);
// });

Route::get('logout', [Login::class, 'logout']);
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

Route::get('/optimize', function () {
    Artisan::call('optimize');
    return "Cache/Route is cleared";
});
