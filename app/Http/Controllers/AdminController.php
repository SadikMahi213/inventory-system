<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\PurchaseRecord;
use App\Models\SalesRecord;
use App\Models\Stock;
use App\Models\ProfitLoss;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard
     *
     * @return View
     */
    public function index(): View
    {
        // Get system statistics
        $stats = [
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'total_purchases' => PurchaseRecord::count(),
            'total_sales' => SalesRecord::count(),
            'total_suppliers' => Supplier::count(),
            'total_customers' => Customer::count(),
            'total_media' => Media::count(),
        ];

        // Get recent activities
        $recentUsers = User::latest()->take(5)->get();
        $recentProducts = Product::with('stock')->latest()->take(5)->get();

        return view('admin.index', compact('stats', 'recentUsers', 'recentProducts'));
    }

    /**
     * Display the users management page
     *
     * @return View
     */
    public function users(): View
    {
        $users = User::latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    /**
     * Display the system settings page
     *
     * @return View
     */
    public function settings(): View
    {
        return view('admin.settings');
    }

    /**
     * Display the system logs page
     *
     * @return View
     */
    public function logs(): View
    {
        return view('admin.logs');
    }

    /**
     * Display the backup management page
     *
     * @return View
     */
    public function backups(): View
    {
        return view('admin.backups');
    }
}