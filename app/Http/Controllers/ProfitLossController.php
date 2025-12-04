<?php

namespace App\Http\Controllers;

use App\Models\ProfitLoss;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfitLossController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = ProfitLoss::with('product');
        
        // Apply search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('product', function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('product_code', 'LIKE', "%{$search}%");
            });
        }
        
        // Apply date filter
        if ($request->has('from_date') && $request->from_date != '') {
            $query->where('report_date', '>=', $request->from_date);
        }
        
        if ($request->has('to_date') && $request->to_date != '') {
            $query->where('report_date', '<=', $request->to_date);
        }
        
        // Apply profit filter
        if ($request->has('profit_filter') && $request->profit_filter != '') {
            switch ($request->profit_filter) {
                case 'profitable':
                    $query->where('net_profit', '>', 0);
                    break;
                case 'unprofitable':
                    $query->where('net_profit', '<=', 0);
                    break;
            }
        }
        
        // Apply sorting
        if ($request->has('sort_by') && $request->sort_by != '') {
            $sortBy = $request->sort_by;
            $direction = $request->has('sort_direction') && $request->sort_direction == 'desc' ? 'desc' : 'asc';
            
            if (in_array($sortBy, ['report_date', 'revenue', 'net_profit'])) {
                $query->orderBy($sortBy, $direction);
            } else {
                $query->latest();
            }
        } else {
            $query->latest();
        }
        
        $profitLossRecords = $query->paginate(10)->appends($request->except('page'));
        
        return view('profit-loss.index', compact('profitLossRecords'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $products = Product::all();
        return view('profit-loss.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => 'nullable|exists:products,id',
            'revenue' => 'required|numeric|min:0',
            'cogs' => 'required|numeric|min:0',
            'staff_cost' => 'required|numeric|min:0',
            'shop_cost' => 'required|numeric|min:0',
            'transport_cost' => 'required|numeric|min:0',
            'other_expense' => 'required|numeric|min:0',
            'report_date' => 'required|date',
        ]);

        // Calculate total expenses and net profit
        $totalExpenses = $request->staff_cost + $request->shop_cost + $request->transport_cost + $request->other_expense;
        $netProfit = $request->revenue - $request->cogs - $totalExpenses;

        ProfitLoss::create([
            'product_id' => $request->product_id,
            'revenue' => $request->revenue,
            'cogs' => $request->cogs,
            'staff_cost' => $request->staff_cost,
            'shop_cost' => $request->shop_cost,
            'transport_cost' => $request->transport_cost,
            'other_expense' => $request->other_expense,
            'total_expenses' => $totalExpenses,
            'net_profit' => $netProfit,
            'report_date' => $request->report_date,
        ]);

        return redirect()->route('profit-loss.index')
            ->with('success', 'Profit & Loss record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProfitLoss $profitLoss): View
    {
        return view('profit-loss.show', compact('profitLoss'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProfitLoss $profitLoss): View
    {
        $products = Product::all();
        return view('profit-loss.edit', compact('profitLoss', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProfitLoss $profitLoss): RedirectResponse
    {
        $request->validate([
            'product_id' => 'nullable|exists:products,id',
            'revenue' => 'required|numeric|min:0',
            'cogs' => 'required|numeric|min:0',
            'staff_cost' => 'required|numeric|min:0',
            'shop_cost' => 'required|numeric|min:0',
            'transport_cost' => 'required|numeric|min:0',
            'other_expense' => 'required|numeric|min:0',
            'report_date' => 'required|date',
        ]);

        // Calculate total expenses and net profit
        $totalExpenses = $request->staff_cost + $request->shop_cost + $request->transport_cost + $request->other_expense;
        $netProfit = $request->revenue - $request->cogs - $totalExpenses;

        $profitLoss->update([
            'product_id' => $request->product_id,
            'revenue' => $request->revenue,
            'cogs' => $request->cogs,
            'staff_cost' => $request->staff_cost,
            'shop_cost' => $request->shop_cost,
            'transport_cost' => $request->transport_cost,
            'other_expense' => $request->other_expense,
            'total_expenses' => $totalExpenses,
            'net_profit' => $netProfit,
            'report_date' => $request->report_date,
        ]);

        return redirect()->route('profit-loss.index')
            ->with('success', 'Profit & Loss record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProfitLoss $profitLoss): RedirectResponse
    {
        $profitLoss->delete();

        return redirect()->route('profit-loss.index')
            ->with('success', 'Profit & Loss record deleted successfully.');
    }
}
