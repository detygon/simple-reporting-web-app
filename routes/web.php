<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', \App\Http\Controllers\DashboardController::class)->middleware(['auth'])->name('dashboard');
Route::get('/customers-report', \App\Http\Controllers\CustomerReportController::class)->middleware(['auth'])->name('customers_report');
Route::get('/net-revenue-report', \App\Http\Controllers\NetRevenueReportController::class)->middleware(['auth'])->name('net_revenue_report');
Route::get('/products-report', \App\Http\Controllers\ProductReportController::class)->middleware(['auth'])->name('products_report');
Route::get('/refunds-report', \App\Http\Controllers\RefundReportController::class)->middleware(['auth'])->name('refunds_report');

require __DIR__.'/auth.php';

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
