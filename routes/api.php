<?php

use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\ReportsController as ApiReports;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function(){
    Route::resource('reports', ApiReports::class)->except([
        'create',
        'edit'
    ]);

    Route::get('/total_report/{status}', [ApiReports::class, 'count_reports']);
    Route::post('/vote/{id_report}', [ApiReports::class, 'vote']);
    Route::delete('/vote/{id_report}', [ApiReports::class, 'unvote']);

    Route::get('/user_report/{id_user}', [ApiReports::class, 'user_report']);
    Route::get('/user_report/{id_user}/{id_report}', [ApiReports::class, 'user_report_detail']);

    Route::get('/provinces', [LocationController::class, 'get_provinces']);
    Route::get('/regencies', [LocationController::class, 'get_regencies']);
    Route::get('/regencies/{id_province}', [LocationController::class, 'get_regencies']);
    Route::get('/districts', [LocationController::class, 'get_districts']);
    Route::get('/districts/{id_regency}', [LocationController::class, 'get_districts']);
    Route::get('/villages', [LocationController::class, 'get_villages']);
    Route::get('/villages/{id_district}', [LocationController::class, 'get_villages']);
});

Route::post('/reports/datatable', [ReportsController::class, 'datatable'])->name('api.report.datatable');
Route::post('/login', [AuthController::class, 'login_api'])->name('api.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('api.logout');

