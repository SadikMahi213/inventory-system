<?php

use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseRecordController;
use App\Http\Controllers\SalesRecordController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ProfitLossController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CostAnalysisController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\CsvController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [WebsiteController::class, 'index'])->name('home');
Route::get('/contact', [WebsiteController::class, 'contact'])->name('contact');
Route::get('/gallery', [WebsiteController::class, 'media'])->name('media');
Route::post('/media/upload', [WebsiteController::class, 'uploadMedia'])->name('media.upload');

// Public routes for downloading templates
Route::get('/products/download-template', [ProductController::class, 'downloadTemplate'])->name('products.download.template');
Route::get('/purchase-records/download-template', [PurchaseRecordController::class, 'downloadTemplate'])->name('purchase-records.download.template');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Products
    Route::get('/products/export', [ProductController::class, 'export'])->name('products.export');
    Route::get('/products/export-data', [ProductController::class, 'exportData'])->name('products.export.data');
    Route::get('/products/import/form', [ProductController::class, 'importForm'])->name('products.import.form');
    Route::post('/products/import', [ProductController::class, 'import'])->name('products.import');
    Route::resource('products', ProductController::class);
    
    // Categories
    Route::get('/categories/download-template', [CategoryController::class, 'downloadTemplate'])->name('categories.download.template');
    Route::get('/categories/import/form', [CategoryController::class, 'importForm'])->name('categories.import.form');
    Route::post('/categories/import', [CategoryController::class, 'import'])->name('categories.import');
    Route::resource('categories', CategoryController::class);
    
    // Purchase Records
    Route::get('/purchase-records/export', [PurchaseRecordController::class, 'export'])->name('purchase-records.export');
    Route::get('/purchase-records/import/form', [PurchaseRecordController::class, 'importForm'])->name('purchase-records.import.form');
    Route::post('/purchase-records/import', [PurchaseRecordController::class, 'import'])->name('purchase-records.import');
    Route::resource('purchase-records', PurchaseRecordController::class);
    
    // Sales Records
    Route::resource('sales-records', SalesRecordController::class);
    
    // Stock
    Route::resource('stocks', StockController::class);
    
    // Profit & Loss
    Route::resource('profit-loss', ProfitLossController::class);
    
    // Suppliers
    Route::resource('suppliers', SupplierController::class);
    
    // Customers
    Route::resource('customers', CustomerController::class);
    
    // Cost Analysis
    Route::resource('cost-analysis', CostAnalysisController::class);
    
    // Media
    Route::resource('media', MediaController::class);
    
    // CSV Import/Export
    Route::get('/csv', [CsvController::class, 'index'])->name('csv.index');
    Route::post('/csv/import/products', [CsvController::class, 'importProducts'])->name('csv.import.products');
    Route::get('/csv/export/products', [CsvController::class, 'exportProducts'])->name('csv.export.products');
    Route::post('/csv/import/purchase-records', [CsvController::class, 'importPurchaseRecords'])->name('csv.import.purchase-records');
    Route::get('/csv/export/purchase-records', [CsvController::class, 'exportPurchaseRecords'])->name('csv.export.purchase-records');
    Route::post('/csv/import/sales-records', [CsvController::class, 'importSalesRecords'])->name('csv.import.sales-records');
    Route::get('/csv/export/sales-records', [CsvController::class, 'exportSalesRecords'])->name('csv.export.sales-records');
    Route::get('/csv/export/stock', [CsvController::class, 'exportStock'])->name('csv.export.stock');
    Route::get('/csv/export/profit-loss', [CsvController::class, 'exportProfitLoss'])->name('csv.export.profit-loss');
    Route::get('/csv/export/suppliers', [CsvController::class, 'exportSuppliers'])->name('csv.export.suppliers');
    Route::get('/csv/export/customers', [CsvController::class, 'exportCustomers'])->name('csv.export.customers');
    
    // Admin Panel
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
        Route::get('/logs', [AdminController::class, 'logs'])->name('admin.logs');
        Route::get('/backups', [AdminController::class, 'backups'])->name('admin.backups');
    });
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';