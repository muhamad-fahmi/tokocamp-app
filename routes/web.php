<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\BlogCategoryController;
use App\Http\Controllers\admin\BlogController;
use App\Http\Controllers\admin\CampinggearController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\PackageController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [PublicController::class, 'index']);

// AUTH
Route::post('/login', [AuthController::class, 'login']);
Route::get('/login', [AuthController::class, 'showlogin'])->name('login');

// GOOGLE O'AUTH
Route::get('auth/google', [AuthController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

// COUNTRY STATE CITY API
Route::post('/api/get-states', [ApiController::class, 'getstates']);
Route::post('/api/get-cities', [ApiController::class, 'getcities']);

// AUTHENTICATED ADMIN
Route::group(['middleware' => ['auth', 'admin']], function () {

    Route::get('/system/admin/dashboard', [AdminController::class, 'index'])->name('dashboardadmin');

    Route::get('/admin/system/accounts', [AdminController::class, 'accounts']);

    Route::resources(
        [
            '/admin/system/category' => CategoryController::class,
            '/admin/system/packages' => PackageController::class,
            '/admin/system/campinggear' => CampinggearController::class,
            '/admin/system/blogs' => BlogController::class,
            '/admin/system/blogcategory' => BlogCategoryController::class,
        ]
    );

    Route::get('/admin/system/logout', [AuthController::class, 'logout'])->name('logoutadmin');
});

// AUTHENTICATED USER
Route::group(['middleware' => ['auth', 'user']], function () {

    Route::get('/home', [UserController::class, 'index'])->name('dashboarduser');

    Route::resources(
        [
            '/cart' => CartController::class,
            '/order' => OrdersController::class,
        ]
    );

    Route::get('/system/logout', [AuthController::class, 'logout'])->name('logoutuser');
});
