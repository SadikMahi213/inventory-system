<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Stock::with('product');
        
        // Apply search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('product', function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('product_code', 'LIKE', "%{$search}%");
            });
        }
        
        // Apply stock level filter
        if ($request->has('stock_level') && $request->stock_level != '') {
            switch ($request->stock_level) {
                case 'low':
                    $query->where('current_stock', '<=', 10);
                    break;
                case 'medium':
                    $query->whereBetween('current_stock', [11, 50]);
                    break;
                case 'high':
                    $query->where('current_stock', '>', 50);
                    break;
            }
        }
        
        // Apply sorting
        if ($request->has('sort_by') && $request->sort_by != '') {
            $sortBy = $request->sort_by;
            $direction = $request->has('sort_direction') && $request->sort_direction == 'desc' ? 'desc' : 'asc';
            
            if (in_array($sortBy, ['product_name', 'current_stock', 'updated_at'])) {
                if ($sortBy == 'product_name') {
                    $query->join('products', 'stocks.product_id', '=', 'products.id')
                          ->orderBy('products.name', $direction)
                          ->select('stocks.*');
                } else {
                    $query->orderBy($sortBy, $direction);
                }
            } else {
                $query->latest();
            }
        } else {
            $query->latest();
        }
        
        $stocks = $query->paginate(10)->appends($request->except('page'));
        
        return view('stocks.index', compact('stocks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Stocks are automatically managed, so we don't need a create form
        return redirect()->route('stocks.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Stocks are automatically managed, so we don't need a store method
        return redirect()->route('stocks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Stock $stock): View
    {
        return view('stocks.show', compact('stock'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stock $stock)
    {
        // Stocks are automatically managed, so we don't need an edit form
        return redirect()->route('stocks.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stock $stock)
    {
        // Stocks are automatically managed, so we don't need an update method
        return redirect()->route('stocks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        // Stocks are automatically managed, so we don't need a destroy method
        return redirect()->route('stocks.index');
    }
}
