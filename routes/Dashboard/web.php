<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\productController;
use App\Http\Controllers\Dashboard\ClientController;
use App\Http\Controllers\Dashboard\Clients\OrderController;
use App\Http\Controllers\Dashboard\OrderController as OrderController2 ;

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

Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function()
{
	/** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/
    Route::prefix('Dashboard')->middleware(['auth'])->group(function () {
        
        Route::get('index', [DashboardController::class, "index"])->name('dashboard.welcome');
        
        //user
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, "index"])->name('dashboard.users.welcome');                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
            Route::get('/create', [UserController::class, "create"])->name('dashboard.users.create');
            Route::post('/store', [UserController::class, "store"])->name('dashboard.users.store');
            Route::get('/edit/{user}', [UserController::class, "edit"])->name('dashboard.users.edit');
            Route::post('/update/{user}', [UserController::class, "update"])->name('dashboard.users.update');
            Route::post('/delete/{user}', [UserController::class, "destroy"])->name('dashboard.users.destroy');   
        });
        // categories
        Route::prefix('categories')->group(function () {
            Route::get('/', [CategoryController::class, "index"])->name('dashboard.categories.index');
            Route::get('/create', [CategoryController::class, "create"])->name('dashboard.categories.create');
            Route::post('/store', [CategoryController::class, "store"])->name('dashboard.categories.store');
            Route::get('/edit/{category}', [CategoryController::class, "edit"])->name('dashboard.category.edit');
            Route::post('/update/{category}', [CategoryController::class, "update"])->name('dashboard.category.update');
            Route::delete('/delete/{category}', [CategoryController::class, "destroy"])->name('dashboard.category.destroy');   
        });

        Route::prefix('product')->group(function () {
            Route::get('/', [productController::class, "index"])->name('dashboard.products.index');
            Route::get('/create', [productController::class, "create"])->name('dashboard.products.create');
            Route::post('/store', [productController::class, "store"])->name('dashboard.products.store');
            Route::get('/edit/{product}', [productController::class, "edit"])->name('dashboard.products.edit');
            Route::post('/update/{product}', [productController::class, "update"])->name('dashboard.products.update');
            Route::delete('/delete/{product}', [productController::class, "destroy"])->name('dashboard.products.destroy');   
        });

        Route::prefix('client')->group(function () {
            Route::get('/', [ClientController::class, "index"])->name('dashboard.clients.index');
            Route::get('/create', [ClientController::class, "create"])->name('dashboard.clients.create');
            Route::post('/store', [ClientController::class, "store"])->name('dashboard.clients.store');
            Route::get('/edit/{client}', [ClientController::class, "edit"])->name('dashboard.clients.edit');
            Route::post('/update/{client}', [ClientController::class, "update"])->name('dashboard.clients.update');
            Route::delete('/delete/{client}', [ClientController::class, "destroy"])->name('dashboard.clients.destroy');   
        });

        Route::prefix('orders')->group(function () {
            Route::get('/', [OrderController2::class, "index"])->name('dashboard.orders.index');
            Route::get('/create/{client}', [OrderController::class, "create"])->name('dashboard.clients.orders.create');
            Route::post('/store/{client}', [OrderController::class, "store"])->name('dashboard.clients.orders.store');
            Route::get('/edit/{client}/{order}', [OrderController::class, "edit"])->name('dashboard.clients.orders.edit');
            Route::post('/update/{client}/{order}', [OrderController::class, "update"])->name('dashboard.clients.orders.update');
            Route::delete('/delete/{order}', [OrderController2::class, "destroy"])->name('dashboard.orders.destroy');   
            Route::get('/products/{order}', [OrderController2::class, "products"])->name('dashboard.orders.products');   
        });
         
    });
});



