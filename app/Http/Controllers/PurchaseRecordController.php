<?php

namespace App\Http\Controllers;

use App\Events\PurchaseRecordCreated;
use App\Models\PurchaseRecord;
use App\Models\Product;
use App\Models\Supplier;
use App\Exports\PurchaseRecordsExport;
use App\Imports\PurchaseRecordsImport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Exception;

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
        return view('purchase-records.create-manual');
    }
    
    /**
     * Show the form for creating a new resource manually.
     */
    public function createManual(): View
    {
        return view('purchase-records.create-manual');
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
            'payment_status' => 'required|in:paid,due,partial',
        ]);

        // Get product details
        $product = Product::findOrFail($request->product_id);

        // Calculate total price
        $totalPrice = $request->quantity * $request->unit_price;

        $purchaseRecord = PurchaseRecord::create([
            'date' => $request->date,
            'product_id' => $request->product_id,
            'product_name' => $product->product_name,
            'model' => $product->model_no,
            'size' => $product->size,
            'color' => $product->color,
            'quality' => $product->grade,
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
     * Store a newly created resource manually in storage.
     */
    public function storeManual(Request $request): RedirectResponse
    {
        // Validate all inputs as nullable
        $request->validate([
            'id' => 'nullable|integer|unique:purchase_records,id',
            'date' => 'nullable|date',
            'invoice_no' => 'nullable|string|max:255',
            'product_id' => 'nullable|integer|min:1',
            'product_name' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:255',
            'color_or_material' => 'nullable|string|max:255',
            'quality' => 'nullable|string|max:255',
            'quantity' => 'nullable|numeric|min:0',
            'unit' => 'nullable|string|max:255',
            'unit_price' => 'nullable|numeric|min:0',
            'total_price' => 'nullable|numeric|min:0',
            'supplier_id' => 'nullable|integer|min:1',
            'payment_status' => 'nullable|in:paid,due,partial',
            'created_at' => 'nullable|date',
            'updated_at' => 'nullable|date',
        ]);

        // Prepare data for insertion - only include fields that are present
        $data = array_filter($request->only([
            'id',
            'date',
            'invoice_no',
            'product_id',
            'product_name',
            'model',
            'size',
            'color_or_material',
            'quality',
            'quantity',
            'unit',
            'unit_price',
            'total_price',
            'supplier_id',
            'payment_status',
            'created_at',
            'updated_at',
        ]), function ($value) {
            return $value !== null && $value !== '';
        });

        // Create the purchase record
        $purchaseRecord = PurchaseRecord::create($data);

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
            'payment_status' => 'required|in:paid,due,partial',
        ]);

        // Get product details
        $product = Product::findOrFail($request->product_id);

        // Calculate total price
        $totalPrice = $request->quantity * $request->unit_price;

        $purchaseRecord->update([
            'date' => $request->date,
            'product_id' => $request->product_id,
            'product_name' => $product->product_name,
            'model' => $product->model_no,
            'size' => $product->size,
            'color' => $product->color,
            'quality' => $product->grade,
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

    /**
     * Download CSV template for purchase records import.
     */
    public function downloadTemplate()
    {
        $headers = [
            'Date',
            'Invoice No',
            'Product ID',
            'Product Name',
            'Model',
            'Size',
            'Color or material',
            'Quality',
            'Quantity',
            'Unit',
            'Unit Price',
            'Total Price',
            'Supplier ID',
            'Payment Status',
        ];
        
        $callback = function() use ($headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
            
            // Add an example row
            $exampleRow = [
                '2025-12-01',
                'INV-001',
                '1',
                'Sample Product',
                'Model X',
                'Large',
                'Black',
                'High',
                '5',
                'piece',
                '100.00',
                '500.00',
                '1',
                'paid',
            ];
            fputcsv($file, $exampleRow);
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=purchase_records_template.csv"
        ]);
    }

    /**
     * Export purchase records to Excel.
     */
    public function export()
    {
        return Excel::download(new PurchaseRecordsExport, 'purchase_records.xlsx');
    }

    /**
     * Show the form for importing purchase records.
     */
    public function importForm(): View
    {
        return view('purchase-records.import');
    }

    /**
     * Import purchase records from Excel/CSV file.
     */
    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new PurchaseRecordsImport, $request->file('file'));
            
            return redirect()->route('purchase-records.index')
                ->with('success', 'Purchase records imported successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Error importing purchase records: ' . $e->getMessage())
                ->withInput();
        }
    }
}