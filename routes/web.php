<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\LabourController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ApprovalOutController;
use App\Http\Controllers\CompanyDataController;
use App\Http\Controllers\MaterialLedgerController;

// Route::permanentRedirect('/', '/login');
Route::get('/', [FrontendController::class, 'index'])->name('home'); // Homepage
Route::get('/about', [FrontendController::class, 'about'])->name('about'); // About Us
Route::get('/product/view/{id}', [FrontendController::class, 'show'])->name('product.show'); // Product Details

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'get_profile_data'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update_profile_data'])->name('profile.update');
    Route::post('/profile_password_update', [ProfileController::class, 'update_profile_password'])->name('profile.update_password');
    Route::resource('purchases', PurchaseController::class);
    Route::resource('approval-outs', ApprovalOutController::class);
    Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
    Route::get('/labours/search', [LabourController::class, 'search']);
    Route::get('/company-data', [CompanyDataController::class, 'edit'])->name('company-data.edit');
    Route::post('/company-data', [CompanyDataController::class, 'update'])->name('company-data.update');
    Route::resource('products', ProductController::class)->except('show');
    Route::get('/material-ledgers', [MaterialLedgerController::class, 'index'])->name('material-ledgers.index');
    Route::get('/view-invoice', function () {
        return view('invoice');
    });

    Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
    Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('/invoices/{invoice}/print', [InvoiceController::class, 'print'])->name('invoices.print');
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::delete('/invoices/{invoice}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');
    Route::get('/products/by-code/{code}', [InvoiceController::class, 'getProductDetail'])->name('invoices.getProductDetail');
    Route::get('/print-product-tag', [ProductController::class, 'printTagsIndex'])->name('products.print-tags-index');
    Route::post('/print-product-tag', [ProductController::class, 'printTagsStore'])->name('products.print-tags-store');
});

require __DIR__ . '/auth.php';
