<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\AuthController;

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

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('process.login');

Route::group(['middleware' => 'auth'],function(){
    Route::resource('admin/dashboard', DashboardController::class)->only([
        'index'
    ]);
    
    Route::resource('admin/reports', ReportsController::class)->except([
        'create',
        'store',
        'edit',
    ]);
    
    Route::resource('admin/users', UsersController::class)->only([
        'index'
    ]);
});

