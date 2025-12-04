<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API routes for our ERP system
Route::middleware('auth:sanctum')->group(function () {
    // Dashboard API
    Route::get('/dashboard/stats', [\App\Http\Controllers\API\DashboardController::class, 'stats']);
    
    // Products API
    Route::apiResource('products', \App\Http\Controllers\API\ProductController::class);
    
    // Purchase Records API
    Route::apiResource('purchase-records', \App\Http\Controllers\API\PurchaseRecordController::class);
    
    // Sales Records API
    Route::apiResource('sales-records', \App\Http\Controllers\API\SalesRecordController::class);
    
    // Stock API
    Route::apiResource('stocks', \App\Http\Controllers\API\StockController::class);
    
    // Profit & Loss API
    Route::apiResource('profit-loss', \App\Http\Controllers\API\ProfitLossController::class);
    
    // Suppliers API
    Route::apiResource('suppliers', \App\Http\Controllers\API\SupplierController::class);
    
    // Customers API
    Route::apiResource('customers', \App\Http\Controllers\API\CustomerController::class);
    
    // Cost Analysis API
    Route::apiResource('cost-analysis', \App\Http\Controllers\API\CostAnalysisController::class);
    
    // Media API
    Route::apiResource('media', \App\Http\Controllers\API\MediaController::class);
});