<?php

namespace App\Http\Controllers;

use App\Events\PurchaseRecordCreated;
use App\Models\PurchaseRecord;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PurchaseRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = PurchaseRecord::with(['product', 'supplier']);
        
        // Apply search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('product_name', 'LIKE', "%{$search}%")
                  ->orWhere('model', 'LIKE', "%{$search}%")
                  ->orWhereHas('supplier', function($sq) use ($search) {
                      $sq->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }
        
        // Apply date filter
        if ($request->has('from_date') && $request->from_date != '') {
            $query->where('date', '>=', $request->from_date);
        }
        
        if ($request->has('to_date') && $request->to_date != '') {
            $query->where('date', '<=', $request->to_date);
        }
        
        // Apply supplier filter
        if ($request->has('supplier_id') && $request->supplier_id != '') {
            $query->where('supplier_id', $request->supplier_id);
        }
        
        // Apply payment status filter
        if ($request->has('payment_status') && $request->payment_status != '') {
            $query->where('payment_status', $request->payment_status);
        }
        
        // Apply sorting
        if ($request->has('sort_by') && $request->sort_by != '') {
            $sortBy = $request->sort_by;
            $direction = $request->has('sort_direction') && $request->sort_direction == 'desc' ? 'desc' : 'asc';
            
            if (in_array($sortBy, ['date', 'product_name', 'quantity', 'total_price', 'payment_status'])) {
                $query->orderBy($sortBy, $direction);
            } else {
                $query->latest();
            }
        } else {
            $query->latest();
        }
        
        $purchaseRecords = $query->paginate(10)->appends($request->except('page'));
        
        // Get products and suppliers for filter dropdowns
        $products = Product::all();
        $suppliers = Supplier::all();
        
        return view('purchase-records.index', compact('purchaseRecords', 'products', 'suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $products = Product::all();
        $suppliers = Supplier::all();
        return view('purchase-records.create', compact('products', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'date' => 'required|date',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'supplier_id' => 'required|exists:suppliers,id',
            'payment_status' => 'required|in:pending,paid,partial',
        ]);

        // Get product details
        $product = Product::findOrFail($request->product_id);

        // Calculate total price
        $totalPrice = $request->quantity * $request->unit_price;

        $purchaseRecord = PurchaseRecord::create([
            'date' => $request->date,
            'product_id' => $request->product_id,
            'product_name' => $product->name,
            'model' => $product->model,
            'size' => $product->size,
            'color' => $product->color,
            'quality' => $product->quality,
            'quantity' => $request->quantity,
            'unit' => $product->unit,
            'unit_price' => $request->unit_price,
            'total_price' => $totalPrice,
            'supplier_id' => $request->supplier_id,
            'payment_status' => $request->payment_status,
        ]);

        // Dispatch event to update stock
        event(new PurchaseRecordCreated($purchaseRecord));

        return redirect()->route('purchase-records.index')
            ->with('success', 'Purchase record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseRecord $purchaseRecord): View
    {
        return view('purchase-records.show', compact('purchaseRecord'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseRecord $purchaseRecord): View
    {
        $products = Product::all();
        $suppliers = Supplier::all();
        return view('purchase-records.edit', compact('purchaseRecord', 'products', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseRecord $purchaseRecord): RedirectResponse
    {
        $request->validate([
            'date' => 'required|date',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'supplier_id' => 'required|exists:suppliers,id',
            'payment_status' => 'required|in:pending,paid,partial',
        ]);

        // Get product details
        $product = Product::findOrFail($request->product_id);

        // Calculate total price
        $totalPrice = $request->quantity * $request->unit_price;

        $purchaseRecord->update([
            'date' => $request->date,
            'product_id' => $request->product_id,
            'product_name' => $product->name,
            'model' => $product->model,
            'size' => $product->size,
            'color' => $product->color,
            'quality' => $product->quality,
            'quantity' => $request->quantity,
            'unit' => $product->unit,
            'unit_price' => $request->unit_price,
            'total_price' => $totalPrice,
            'supplier_id' => $request->supplier_id,
            'payment_status' => $request->payment_status,
        ]);

        return redirect()->route('purchase-records.index')
            ->with('success', 'Purchase record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseRecord $purchaseRecord): RedirectResponse
    {
        $purchaseRecord->delete();

        return redirect()->route('purchase-records.index')
            ->with('success', 'Purchase record deleted successfully.');
    }
}
