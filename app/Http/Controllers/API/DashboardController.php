<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\PurchaseRecord;
use App\Models\SalesRecord;
use App\Models\Stock;
use App\Models\ProfitLoss;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function stats(): JsonResponse
    {
        // Get dashboard statistics
        $totalProducts = Product::count();
        $totalStock = Stock::sum('current_stock');
        $todaySales = SalesRecord::whereDate('created_at', today())->sum('total_amount');
        $monthlyRevenue = SalesRecord::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');
        
        // Calculate net profit
        $netProfit = ProfitLoss::sum('net_profit');
        
        // Get recent sales
        $recentSales = SalesRecord::with('product', 'customer')
            ->latest()
            ->take(5)
            ->get();
            
        // Get low stock items
        $lowStockItems = Stock::with('product')
            ->where('current_stock', '<=', 10)
            ->take(5)
            ->get();
            
        // Get fast moving products (top 5 by sales quantity)
        $fastMovingProducts = SalesRecord::selectRaw('product_id, product_name, SUM(quantity) as total_quantity')
            ->groupBy('product_id', 'product_name')
            ->orderByDesc('total_quantity')
            ->take(5)
            ->get();

        return response()->json([
            'total_products' => $totalProducts,
            'total_stock' => $totalStock,
            'today_sales' => $todaySales,
            'monthly_revenue' => $monthlyRevenue,
            'net_profit' => $netProfit,
            'recent_sales' => $recentSales,
            'low_stock_items' => $lowStockItems,
            'fast_moving_products' => $fastMovingProducts,
        ]);
    }
}
