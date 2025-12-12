<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Route;

// Landing page (not authenticated)
Route::get('/', function () {
    return view('welcome');
})->name("welcome");

// Authentication routes (Breeze)
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin routes only
    Route::middleware('admin')->group(function () {
        // Products
        Route::get('/product/barcodes', [ProductController::class, 'generateBarcodes'])->name('products.barcodes');
        Route::resource('products', ProductController::class);
        Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
        Route::get('/product/code/{code}', [ProductController::class, 'getByCode'])->name('product.bycode');

        // Sales History
        Route::resource('sales', SalesController::class, ['only' => ['index', 'show']]);
        Route::post('/sales/filter', [SalesController::class, 'filter'])->name('sales.filter');
        Route::get('/sales/{sale}/receipt', [SalesController::class, 'downloadReceipt'])->name('sales.receipt');
    });

    // POS routes (for authorized users)
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::get('/pos/product/{id}', [PosController::class, 'getProduct'])->name('pos.product');
    Route::post('/pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');
    Route::get('/pos/receipt/{id}', [PosController::class, 'receipt'])->name('pos.receipt');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
