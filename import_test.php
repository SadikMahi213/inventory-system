<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

try {
    echo "Starting import test...\n";
    
    // First, let's check what's in the products table before import
    echo "Products before import: " . DB::table('products')->count() . "\n";
    
    // Create a simple test CSV file with unique product codes
    $testData = [
        ['product_name', 'size', 'brand', 'grade', 'material', 'color', 'model_no', 'product_code', 'unit_qty', 'unit', 'unit_rate', 'total_buy', 'category', 'quantity', 'approximate_rate', 'authentication_rate', 'sell_rate'],
        ['Test Product 1', 'Medium', 'Test Brand', 'A', 'Steel', 'Red', 'TM-001', 'TP001_UNIQUE', '10', 'piece', '5.50', '55.00', 'Test Category', '100', '5.00', '6.00', '8.00'],
        ['Test Product 2', 'Large', 'Test Brand', 'B', 'Aluminum', 'Blue', 'TM-002', 'TP002_UNIQUE', '5', 'piece', '10.00', '50.00', 'Test Category', '50', '9.00', '11.00', '15.00'],
    ];
    
    $testFile = 'test_import.csv';
    $fp = fopen($testFile, 'w');
    foreach ($testData as $row) {
        fputcsv($fp, $row);
    }
    fclose($fp);
    
    echo "Created test CSV file\n";
    
    // Try to import the file
    echo "Attempting to import...\n";
    Excel::import(new ProductsImport, $testFile);
    
    echo "Import completed successfully!\n";
    
    // Check what's in the products table after import
    echo "Products after import: " . DB::table('products')->count() . "\n";
    
    // Clean up test file
    unlink($testFile);
    
} catch (Exception $e) {
    echo "Error during import: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
    
    // Clean up test file if it exists
    if (file_exists('test_import.csv')) {
        unlink('test_import.csv');
    }
}

?>