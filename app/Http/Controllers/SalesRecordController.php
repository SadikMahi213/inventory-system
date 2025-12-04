<?php

namespace App\Http\Controllers;

use App\Events\SalesRecordCreated;
use App\Models\SalesRecord;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;

class SalesRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = SalesRecord::with(['product', 'customer']);
        
        // Apply search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('invoice_no', 'LIKE', "%{$search}%")
                  ->orWhere('product_name', 'LIKE', "%{$search}%")
                  ->orWhereHas('customer', function($sq) use ($search) {
                      $sq->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }
        
        // Apply date filter
        if ($request->has('from_date') && $request->from_date != '') {
            $query->where('created_at', '>=', $request->from_date);
        }
        
        if ($request->has('to_date') && $request->to_date != '') {
            $query->where('created_at', '<=', $request->to_date);
        }
        
        // Apply customer filter
        if ($request->has('customer_id') && $request->customer_id != '') {
            $query->where('customer_id', $request->customer_id);
        }
        
        // Apply payment status filter
        if ($request->has('payment_status') && $request->payment_status != '') {
            $query->where('payment_status', $request->payment_status);
        }
        
        // Apply sorting
        if ($request->has('sort_by') && $request->sort_by != '') {
            $sortBy = $request->sort_by;
            $direction = $request->has('sort_direction') && $request->sort_direction == 'desc' ? 'desc' : 'asc';
            
            if (in_array($sortBy, ['created_at', 'invoice_no', 'product_name', 'quantity', 'total_amount', 'payment_status'])) {
                $query->orderBy($sortBy, $direction);
            } else {
                $query->latest();
            }
        } else {
            $query->latest();
        }
        
        $salesRecords = $query->paginate(10)->appends($request->except('page'));
        
        // Get products and customers for filter dropdowns
        $products = Product::all();
        $customers = Customer::all();
        
        return view('sales-records.index', compact('salesRecords', 'products', 'customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $products = Product::all();
        $customers = Customer::all();
        return view('sales-records.create', compact('products', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'payment_status' => 'required|in:pending,paid,partial',
        ]);

        // Generate unique invoice number
        $invoiceNo = 'INV-' . strtoupper(Str::random(8));
        while (SalesRecord::where('invoice_no', $invoiceNo)->exists()) {
            $invoiceNo = 'INV-' . strtoupper(Str::random(8));
        }

        // Get product details
        $product = Product::findOrFail($request->product_id);

        // Calculate total amount
        $totalAmount = $request->price * $request->quantity;

        $salesRecord = SalesRecord::create([
            'invoice_no' => $invoiceNo,
            'customer_id' => $request->customer_id,
            'product_id' => $request->product_id,
            'product_name' => $product->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'total_amount' => $totalAmount,
            'payment_status' => $request->payment_status,
        ]);

        // Dispatch event to update stock
        event(new SalesRecordCreated($salesRecord));

        return redirect()->route('sales-records.index')
            ->with('success', 'Sales record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SalesRecord $salesRecord): View
    {
        return view('sales-records.show', compact('salesRecord'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesRecord $salesRecord): View
    {
        $products = Product::all();
        $customers = Customer::all();
        return view('sales-records.edit', compact('salesRecord', 'products', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesRecord $salesRecord): RedirectResponse
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'payment_status' => 'required|in:pending,paid,partial',
        ]);

        // Get product details
        $product = Product::findOrFail($request->product_id);

        // Calculate total amount
        $totalAmount = $request->price * $request->quantity;

        $salesRecord->update([
            'customer_id' => $request->customer_id,
            'product_id' => $request->product_id,
            'product_name' => $product->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'total_amount' => $totalAmount,
            'payment_status' => $request->payment_status,
        ]);

        return redirect()->route('sales-records.index')
            ->with('success', 'Sales record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesRecord $salesRecord): RedirectResponse
    {
        $salesRecord->delete();

        return redirect()->route('sales-records.index')
            ->with('success', 'Sales record deleted successfully.');
    }
}
