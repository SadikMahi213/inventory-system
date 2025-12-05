<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PurchaseRecord;
use App\Models\SalesRecord;
use App\Models\Stock;
use App\Models\ProfitLoss;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Exception;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Get dashboard statistics with safe fallbacks
        try {
            $totalProducts = Schema::hasTable('products') ? Product::count() : 0;
        } catch (Exception $e) {
            $totalProducts = 0;
        }
        
        try {
            $totalStock = Schema::hasTable('stocks') ? Stock::sum('current_stock') : 0;
        } catch (Exception $e) {
            $totalStock = 0;
        }
        
        try {
            $todaySales = Schema::hasTable('sales_records') ? SalesRecord::whereDate('created_at', today())->sum('total_amount') : 0;
        } catch (Exception $e) {
            $todaySales = 0;
        }
        
        try {
            $monthlyRevenue = Schema::hasTable('sales_records') ? SalesRecord::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total_amount') : 0;
        } catch (Exception $e) {
            $monthlyRevenue = 0;
        }
        
        // Calculate net profit with safe fallback
        try {
            $netProfit = Schema::hasTable('profit_losses') ? ProfitLoss::sum('net_profit') : 0;
        } catch (Exception $e) {
            $netProfit = 0;
        }
        
        // Get recent sales with safe fallback
        try {
            $recentSales = Schema::hasTable('sales_records') ? SalesRecord::with('product', 'customer')
                ->latest()
                ->take(5)
                ->get() : collect();
        } catch (Exception $e) {
            $recentSales = collect();
        }
            
        // Get low stock items with safe fallback
        try {
            $lowStockItems = Schema::hasTable('stocks') ? Stock::with('product')
                ->where('current_stock', '<=', 10)
                ->take(5)
                ->get() : collect();
        } catch (Exception $e) {
            $lowStockItems = collect();
        }
            
        // Get fast moving products with safe fallback
        try {
            $fastMovingProducts = Schema::hasTable('sales_records') ? SalesRecord::selectRaw('product_id, product_name, SUM(quantity) as total_quantity')
                ->groupBy('product_id', 'product_name')
                ->orderByDesc('total_quantity')
                ->take(5)
                ->get() : collect();
        } catch (Exception $e) {
            $fastMovingProducts = collect();
        }

        return view('dashboard.index', compact(
            'totalProducts',
            'totalStock',
            'todaySales',
            'monthlyRevenue',
            'netProfit',
            'recentSales',
            'lowStockItems',
            'fastMovingProducts'
        ));
    }
}
