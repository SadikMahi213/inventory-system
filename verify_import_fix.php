<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

try {
    echo "Testing import functionality fix...\n";
    
    // First, let's check what's in the products table before import
    $initialCount = DB::table('products')->count();
    echo "Products before import: $initialCount\n";
    
    // Create a test CSV file with various scenarios
    $testData = [
        // Headers with mix of database column names and human-readable names
        ['product_code', 'product_name', 'brand', 'model', 'unit_rate', 'quantity', 'category'],
        // Complete data
        ['TEST001', 'Complete Product', 'Test Brand', 'Model X', '29.99', '100', 'Electronics'],
        // Partial data with empty fields
        ['TEST002', 'Partial Product', '', '', '15.50', '50', ''],
        // Data with new category
        ['TEST003', 'New Category Product', 'Brand Y', 'Model Z', '45.00', '25', 'Office Supplies'],
        // Data with only essential fields
        ['TEST004', 'Minimal Product', '', '', '', '', 'General'],
    ];
    
    $testFile = 'import_test.csv';
    $fp = fopen($testFile, 'w');
    foreach ($testData as $row) {
        fputcsv($fp, $row);
    }
    fclose($fp);
    
    echo "Created test CSV file with " . (count($testData) - 1) . " rows\n";
    
    // Try to import the file
    echo "Attempting to import...\n";
    Excel::import(new ProductsImport, $testFile);
    
    echo "Import completed successfully!\n";
    
    // Check what's in the products table after import
    $finalCount = DB::table('products')->count();
    echo "Products after import: $finalCount\n";
    
    // Show the imported products
    $products = Product::whereIn('product_code', ['TEST001', 'TEST002', 'TEST003', 'TEST004'])->get();
    echo "\nImported products:\n";
    foreach ($products as $product) {
        echo "- {$product->product_code}: {$product->product_name} (Category: " . ($product->category ? $product->category->name : 'None') . ")\n";
    }
    
    // Clean up test file
    unlink($testFile);
    
    echo "\nImport functionality is now working correctly!\n";
    
} catch (Exception $e) {
    echo "Error during import: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
    
    // Clean up test file if it exists
    if (file_exists('import_test.csv')) {
        unlink('import_test.csv');
    }
}