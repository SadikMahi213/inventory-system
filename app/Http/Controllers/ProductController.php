<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Exports\ProductsExport;
use App\Exports\ProductsTemplateExport;
use App\Imports\ProductsImport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Exception;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Product::with('category');
        
        // Apply search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('product_name', 'LIKE', "%{$search}%")
                  ->orWhere('product_code', 'LIKE', "%{$search}%")
                  ->orWhere('brand', 'LIKE', "%{$search}%")
                  ->orWhere('model_no', 'LIKE', "%{$search}%")
                  ->orWhere('color', 'LIKE', "%{$search}%");
            });
        }
        
        // Apply sorting
        if ($request->has('sort_by') && $request->sort_by != '') {
            $sortBy = $request->sort_by;
            $direction = $request->has('sort_direction') && $request->sort_direction == 'desc' ? 'desc' : 'asc';
            
            if (in_array($sortBy, ['product_name', 'product_code', 'unit_rate', 'created_at'])) {
                $query->orderBy($sortBy, $direction);
            } else {
                $query->latest();
            }
        } else {
            $query->latest();
        }
        
        $products = $query->paginate(10)->appends($request->except('page'));
        $categories = Schema::hasTable('categories') ? Category::all() : collect([]);
        
        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Schema::hasTable('categories') ? Category::all() : collect([]);
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'size' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'grade' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'model_no' => 'nullable|string|max:255',
            'product_code' => 'required|string|unique:products,product_code|max:255',
            'unit_qty' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'unit_rate' => 'required|numeric|min:0',
            'total_buy' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'required|numeric|min:0',
            'approximate_rate' => 'required|numeric|min:0',
            'authentication_rate' => 'required|numeric|min:0',
            'sell_rate' => 'required|numeric|min:0',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        $product->load('category');
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        $categories = Schema::hasTable('categories') ? Category::all() : collect([]);
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'size' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'grade' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'model_no' => 'nullable|string|max:255',
            'product_code' => 'required|string|unique:products,product_code,'.$product->id.'|max:255',
            'unit_qty' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'unit_rate' => 'required|numeric|min:0',
            'total_buy' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'required|numeric|min:0',
            'approximate_rate' => 'required|numeric|min:0',
            'authentication_rate' => 'required|numeric|min:0',
            'sell_rate' => 'required|numeric|min:0',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Show the form for importing products.
     */
    public function importForm(): View
    {
        return view('products.import');
    }

    /**
     * Import products from Excel/CSV file.
     */
    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240' // 10MB max
        ], [
            'file.required' => 'Please select a file to import.',
            'file.mimes' => 'Only Excel (.xlsx, .xls) and CSV files are allowed.',
            'file.max' => 'File size must not exceed 10MB.'
        ]);

        try {
            Excel::import(new ProductsImport, $request->file('file'));
            
            return redirect()->route('products.index')
                ->with('success', 'Products imported successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Error importing products: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Export products to Excel.
     */
    public function export()
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }

    /**
     * Download CSV template for product import.
     */
    public function downloadTemplate()
    {
        $headers = [
            'product_code',
            'unit_qty',
            'unit_rate',
            'total_buy',
            'product_name',
            'model',
            'size',
            'brand',
            'grade',
            'material',
            'color',
            'model_no',
            'quality',
            'unit',
            'unit_price',
            'selling_price',
            'description',
            'is_featured',
            'category',
            'quantity',
            'approximate_rate',
            'authentication_rate',
            'sell_rate'
        ];
        
        $callback = function() use ($headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
            fclose($file);
        };
        
        return response()->stream($callback, 200, [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=product_template.csv"
        ]);
    }

    /**
     * Export all products data to CSV.
     */
    public function exportData()
    {
        $headers = [
            'product_code',
            'unit_qty',
            'unit_rate',
            'total_buy',
            'product_name',
            'model',
            'size',
            'brand',
            'grade',
            'material',
            'color',
            'model_no',
            'quality',
            'unit',
            'unit_price',
            'selling_price',
            'description',
            'is_featured',
            'category',
            'quantity',
            'approximate_rate',
            'authentication_rate',
            'sell_rate'
        ];
        
        $products = Product::all();
        
        $callback = function() use ($headers, $products) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
            
            foreach ($products as $product) {
                $row = [
                    $product->product_code,
                    $product->unit_qty,
                    $product->unit_rate,
                    $product->total_buy,
                    $product->product_name,
                    $product->model,
                    $product->size,
                    $product->brand,
                    $product->grade,
                    $product->material,
                    $product->color,
                    $product->model_no,
                    $product->quality,
                    $product->unit,
                    $product->unit_price,
                    $product->selling_price,
                    $product->description,
                    $product->is_featured,
                    $product->category ? $product->category->name : '',
                    $product->quantity,
                    $product->approximate_rate,
                    $product->authentication_rate,
                    $product->sell_rate
                ];
                fputcsv($file, $row);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=product_data.csv"
        ]);
    }
}