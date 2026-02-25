<?php

use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\ReportController;
use App\Http\Controllers\Web\SaleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::resource('products', ProductController::class);

Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
Route::post('/sales/store', [SaleController::class, 'store'])->name('sales.store');

Route::get('/report', [ReportController::class, 'index'])->name('report.index');
