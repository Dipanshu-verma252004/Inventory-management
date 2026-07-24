<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReportController;


Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('register');
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {

    Route::resource('categories', CategoryController::class);

});

Route::resource('brands', BrandController::class);
Route::resource('units', UnitController::class);
Route::resource('suppliers', SupplierController::class);
Route::resource('products', ProductController::class);
Route::resource('purchases', PurchaseController::class);
Route::get('purchases/{purchase}/print',[PurchaseController::class,'print'])->name('purchases.print');
Route::resource('customers', CustomerController::class);
Route::get('sales/report', [SaleController::class, 'report'])->name('sales.report');
Route::resource('sales', SaleController::class);
Route::get('sales/{sale}/print',[SaleController::class,'print'])->name('sales.print');
Route::prefix('reports')->name('reports.')->group(function () {

    Route::get('/stock', [ReportController::class, 'stock'])
        ->name('stock');
    Route::get('/purchase', [ReportController::class, 'purchase'])->name('purchase');
    Route::get('/sales', [ReportController::class, 'sales'])->name('sales');
    Route::get('/low-stock', [ReportController::class, 'lowStock'])->name('low-stock');
    Route::get('/profit', [ReportController::class, 'profit'])->name('profit');

});

require __DIR__.'/auth.php';
