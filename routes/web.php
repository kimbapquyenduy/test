<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\MyController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ManufactureController;


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
//lists manufacture
Route::prefix('manufacture')->name('manufacture.')->group(function () {
    Route::get('/', [ManufactureController::class, 'index_manufacture'])->name('index_manufacture');

    Route::get('/add_manufacture', [ManufactureController::class, 'add_manufacture'])->name('add_manufacture');
    Route::post('/add_manufacture', [ManufactureController::class, 'postAdd_manufacture'])->name('post-add_manufacture');

    // Route::get('/edit_manufacture/{manufacture_id}',[ManufactureController::class, 'getEdit_manufacture'])->name('edit_manufacture');
    // Route::post('/update_manufacture',[ManufactureController::class, 'postEdit_manufacture'])->name('post-edit_manufacture');

    Route::get('/delete/{manufacture_id}', [ManufactureController::class, 'delete'])->name('delete');
});

//danh sach san pham
Route::prefix('product')->name('product.')->group(function () {
    Route::get('/', [ProductController::class, 'index_product'])->name('index_product');

    Route::get('/add_product', [ProductController::class, 'add_product'])->name('add_product');
    Route::post('/add_product', [ProductController::class, 'postAdd_product'])->name('post-add_product');

    // Route::get('/edit_type/{type_id}',[TypeController::class, 'getEdit_type'])->name('edit_type');
    // Route::post('/update_type',[TypeController::class, 'postEdit_type'])->name('post-edit_type');

    Route::get('/delete/{id}', [ProductController::class, 'delete'])->name('delete');
});

//danh s??ch loai s???n ph???m
Route::prefix('type')->name('type.')->group(function () {
    Route::get('/', [TypeController::class, 'index_type'])->name('index_type');

    Route::get('/add_type', [TypeController::class, 'add_type'])->name('add_type');
    Route::post('/add_type', [TypeController::class, 'postAdd_type'])->name('post-add_type');

    Route::get('/delete/{type_id}', [TypeController::class, 'delete'])->name('delete');
});
Route::get('/edit-product_type/{type_id}', [TypeController::class, 'edit']);
//Route::post('/update-product_type/{type_id}',[TypeController::class, 'update']);


//danh sach nguoi dung
Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [UsersController::class, 'index'])->name('index');

    Route::get('/add', [UsersController::class, 'add'])->name('add');
    Route::post('/add', [UsersController::class, 'postAdd'])->name('post-add');

    Route::get('/delete/{id}', [UsersController::class, 'delete'])->name('delete');
});
Route::get('/edit-users/{id}', [UsersController::class, 'edit']);
Route::post('/update-users/{id}', [UsersController::class, 'update']);

//dashboard
Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index')->name('dashboard');
});
//end dashboard

require __DIR__ . '/auth.php';
//start cart route
Route::get('/addcart/{id}', [MyController::class, 'AddCart']);
Route::get('/delcart/{id}', [MyController::class, 'DeleteCart']);
Route::get('/dellistcart/{id}', [MyController::class, 'DeleteListCart']);
Route::get('/updatelistcart/{id}/{quan}', [MyController::class, 'UpdateListCart']);
//end cart route
//start gallery route
Route::get('/showall', [MyController::class, 'ShowAllProduct']);
Route::get('/showfeature', [MyController::class, 'ShowFeatureProduct']);
Route::get('/showhightolow', [MyController::class, 'ShowProductPriceHighToLow']);
Route::get('/showlowtohigh', [MyController::class, 'ShowProductPriceLowToHigh']);
Route::get('/showbestselling', [MyController::class, 'ShowProductBestSelling']);
//end gallery route
//Route::get('/', [ProductTypeController::class, 'getProductType']);
Route::post('/shop', [MyController::class, 'searchProductByName']);
Route::get('/', [MyController::class, 'index']);
Route::get('/{tenmien?}', [MyController::class, 'page']);
Route::get('/producttype/{id}', [MyController::class, 'getProductByTypeID']);
// Route::get('/shop-detail/{id}', [MyController::class, 'getProductByManuID']);
Route::get('/shop-detail/{id}', [MyController::class, 'getProductById']);
