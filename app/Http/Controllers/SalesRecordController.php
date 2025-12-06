<?php

namespace App\Http\Controllers;

use App\Events\SalesRecordCreated;
use App\Models\SalesRecord;
use App\Models\Product;
use App\Models\Customer;
use App\Imports\SalesRecordsImport;
use App\Exports\SalesRecordsExport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Exception;

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
     * Show the form for manual entry.
     */
    public function createManual(): View
    {
        $products = Product::all();
        $customers = Customer::all();
        return view('sales-records.create-manual', compact('products', 'customers'));
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
     * Store a manually created resource in storage.
     */
    public function storeManual(Request $request): RedirectResponse
    {
        $request->validate([
            'invoice_no' => 'required|string|max:255|unique:sales_records,invoice_no',
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'payment_status' => 'required|in:pending,paid,partial',
        ]);

        // Calculate total amount
        $totalAmount = $request->price * $request->quantity;

        $salesRecord = SalesRecord::create([
            'invoice_no' => $request->invoice_no,
            'customer_id' => $request->customer_id,
            'product_id' => $request->product_id,
            'product_name' => $request->product_name,
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
            'invoice_no' => 'required|string|max:255|unique:sales_records,invoice_no,'.$salesRecord->id,
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'payment_status' => 'required|in:pending,paid,partial',
        ]);

        // Calculate total amount
        $totalAmount = $request->price * $request->quantity;

        $salesRecord->update([
            'invoice_no' => $request->invoice_no,
            'customer_id' => $request->customer_id,
            'product_id' => $request->product_id,
            'product_name' => $request->product_name,
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

    /**
     * Show the import form.
     */
    public function importView(): View
    {
        return view('sales-records.import');
    }

    /**
     * Import sales records from Excel/CSV file.
     */
    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt,xlsx,xls'
        ]);

        try {
            $file = $request->file('csv_file');
            $extension = $file->getClientOriginalExtension();
            
            if (in_array($extension, ['csv', 'txt'])) {
                // Handle CSV files
                $path = $file->getRealPath();
                $rows = array_map('str_getcsv', file($path));
                
                if (count($rows) <= 1) {
                    return redirect()->back()->with('error', 'CSV file is empty or invalid.');
                }
                
                $header = array_map('trim', $rows[0]);
                unset($rows[0]); // remove header row

                foreach ($rows as $row) {
                    if (count($row) != count($header)) {
                        continue; // Skip rows with mismatched columns
                    }
                    
                    $data = array_combine($header, $row);
                    
                    // Validate required fields
                    if (empty($data['invoice_no']) || empty($data['customer_id']) || empty($data['product_id']) || 
                        empty($data['product_name']) || empty($data['price']) || empty($data['quantity'])) {
                        continue; // Skip invalid rows
                    }
                    
                    // Calculate total amount
                    $totalAmount = $data['price'] * $data['quantity'];
                    
                    // Prepare timestamps
                    $now = now();
                    $createdAt = isset($data['created_at']) ? $data['created_at'] : $now;
                    $updatedAt = isset($data['updated_at']) ? $data['updated_at'] : $now;
                    
                    // Use updateOrCreate to avoid duplicates
                    SalesRecord::updateOrCreate(
                        ['invoice_no' => $data['invoice_no']], // unique key
                        [
                            'customer_id' => $data['customer_id'],
                            'product_id' => $data['product_id'],
                            'product_name' => $data['product_name'],
                            'price' => $data['price'],
                            'quantity' => $data['quantity'],
                            'total_amount' => $totalAmount,
                            'payment_status' => $data['payment_status'] ?? 'pending',
                            'created_at' => $createdAt,
                            'updated_at' => $updatedAt,
                        ]
                    );
                }
            } else {
                // Handle Excel files using the existing import class
                Excel::import(new SalesRecordsImport, $file);
            }
            
            return redirect()->route('sales-records.index')
                ->with('success', 'Sales records imported successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Error importing sales records: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Export sales records to Excel/CSV file.
     */
    public function export()
    {
        return Excel::download(new SalesRecordsExport, 'sales_records.xlsx');
    }

    /**
     * Download CSV template for sales records import.
     */
    public function downloadTemplate()
    {
        $headers = [
            'invoice_no',
            'customer_id',
            'product_id',
            'product_name',
            'price',
            'quantity',
            'total_amount',
            'payment_status'
        ];
        
        $callback = function() use ($headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
            
            // Add an example row
            $exampleRow = [
                'INV-001',
                '1',
                '1',
                'Sample Product',
                '100.00',
                '5',
                '500.00',
                'pending'
            ];
            fputcsv($file, $exampleRow);
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=sales_records_template.csv"
        ]);
    }
}