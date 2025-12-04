<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PurchaseRecord;
use App\Models\SalesRecord;
use App\Models\Stock;
use App\Models\ProfitLoss;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
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
