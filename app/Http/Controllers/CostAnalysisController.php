<?php

namespace App\Http\Controllers;

use App\Models\CostAnalysis;
use App\Models\Product;
use App\Models\PurchaseRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CostAnalysisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $costAnalyses = CostAnalysis::with(['product', 'purchaseRecord'])->latest()->paginate(10);
        return view('cost-analysis.index', compact('costAnalyses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $products = Product::all();
        $purchaseRecords = PurchaseRecord::all();
        return view('cost-analysis.create', compact('products', 'purchaseRecords'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'purchase_record_id' => 'required|exists:purchase_records,id',
            'staff_cost' => 'required|numeric|min:0',
            'shop_cost' => 'required|numeric|min:0',
            'transport_cost' => 'required|numeric|min:0',
            'other_expense' => 'required|numeric|min:0',
            'final_selling_price' => 'required|numeric|min:0',
        ]);

        // Calculate total additional cost
        $totalAdditionalCost = $request->staff_cost + $request->shop_cost + $request->transport_cost + $request->other_expense;

        CostAnalysis::create([
            'product_id' => $request->product_id,
            'purchase_record_id' => $request->purchase_record_id,
            'staff_cost' => $request->staff_cost,
            'shop_cost' => $request->shop_cost,
            'transport_cost' => $request->transport_cost,
            'other_expense' => $request->other_expense,
            'total_additional_cost' => $totalAdditionalCost,
            'final_selling_price' => $request->final_selling_price,
        ]);

        return redirect()->route('cost-analysis.index')
            ->with('success', 'Cost analysis created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CostAnalysis $costAnalysis): View
    {
        return view('cost-analysis.show', compact('costAnalysis'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CostAnalysis $costAnalysis): View
    {
        $products = Product::all();
        $purchaseRecords = PurchaseRecord::all();
        return view('cost-analysis.edit', compact('costAnalysis', 'products', 'purchaseRecords'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CostAnalysis $costAnalysis): RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'purchase_record_id' => 'required|exists:purchase_records,id',
            'staff_cost' => 'required|numeric|min:0',
            'shop_cost' => 'required|numeric|min:0',
            'transport_cost' => 'required|numeric|min:0',
            'other_expense' => 'required|numeric|min:0',
            'final_selling_price' => 'required|numeric|min:0',
        ]);

        // Calculate total additional cost
        $totalAdditionalCost = $request->staff_cost + $request->shop_cost + $request->transport_cost + $request->other_expense;

        $costAnalysis->update([
            'product_id' => $request->product_id,
            'purchase_record_id' => $request->purchase_record_id,
            'staff_cost' => $request->staff_cost,
            'shop_cost' => $request->shop_cost,
            'transport_cost' => $request->transport_cost,
            'other_expense' => $request->other_expense,
            'total_additional_cost' => $totalAdditionalCost,
            'final_selling_price' => $request->final_selling_price,
        ]);

        return redirect()->route('cost-analysis.index')
            ->with('success', 'Cost analysis updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CostAnalysis $costAnalysis): RedirectResponse
    {
        $costAnalysis->delete();

        return redirect()->route('cost-analysis.index')
            ->with('success', 'Cost analysis deleted successfully.');
    }
}
