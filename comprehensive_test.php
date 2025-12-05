<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\UploadedFile;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

try {
    echo "Starting comprehensive import test...\n";
    
    // Enable logging for this test
    Log::info('=== Comprehensive Import Test Started ===');
    
    // First, let's check what's in the products table before import
    $initialProductCount = DB::table('products')->count();
    echo "Products before import: $initialProductCount\n";
    Log::info("Products before import: $initialProductCount");
    
    // Check the actual column names in the products table
    $productColumns = DB::getSchemaBuilder()->getColumnListing('products');
    echo "Actual products table columns: " . implode(', ', $productColumns) . "\n";
    Log::info("Actual products table columns: " . implode(', ', $productColumns));
    
    // Create a test CSV file with the exact format expected by the import
    // Using column names that match what the ProductsImport class expects
    $testData = [
        ['product_name', 'size', 'brand', 'grade', 'material', 'color', 'model_no', 'product_code', 'unit_qty', 'unit', 'unit_rate', 'total_buy', 'category', 'quantity', 'approximate_rate', 'authentication_rate', 'sell_rate'],
        ['Comprehensive Test 1', 'Medium', 'CompBrand', 'A', 'Steel', 'Red', 'CT-001', 'CT001_UNIQUE', '10', 'piece', '5.50', '55.00', 'Test Category', '100', '5.00', '6.00', '8.00'],
        ['Comprehensive Test 2', 'Large', 'CompBrand', 'B', 'Aluminum', 'Blue', 'CT-002', 'CT002_UNIQUE', '5', 'piece', '10.00', '50.00', 'Test Category', '50', '9.00', '11.00', '15.00'],
        // Add a row with missing total_buy to test auto-calculation
        ['Comprehensive Test 3', 'Small', 'CompBrand', 'C', 'Plastic', 'Green', 'CT-003', 'CT003_UNIQUE', '8', 'piece', '7.50', '', 'Test Category', '75', '7.00', '8.00', '12.00'],
    ];
    
    $testFile = 'comprehensive_test.csv';
    $fp = fopen($testFile, 'w');
    foreach ($testData as $row) {
        fputcsv($fp, $row);
    }
    fclose($fp);
    
    echo "Created comprehensive test CSV file\n";
    Log::info("Created comprehensive test CSV file");
    
    // Create an UploadedFile instance to simulate a web upload
    $uploadedFile = new UploadedFile(
        $testFile,
        'comprehensive_test.csv',
        'text/csv',
        null,
        true // Test mode
    );
    
    echo "Created UploadedFile instance\n";
    Log::info("Created UploadedFile instance");
    
    // Try to import the file using the same method as the web controller
    echo "Attempting to import using Excel::import...\n";
    Log::info("Attempting to import using Excel::import...");
    
    Excel::import(new ProductsImport, $uploadedFile);
    
    echo "Import completed successfully!\n";
    Log::info("Import completed successfully!");
    
    // Check what's in the products table after import
    $finalProductCount = DB::table('products')->count();
    echo "Products after import: $finalProductCount\n";
    Log::info("Products after import: $finalProductCount");
    
    $importedCount = $finalProductCount - $initialProductCount;
    echo "Number of products imported: $importedCount\n";
    Log::info("Number of products imported: $importedCount");
    
    // Show the newly imported products
    $newProducts = DB::table('products')->orderBy('id', 'desc')->limit($importedCount)->get();
    echo "Newly imported products:\n";
    foreach ($newProducts as $product) {
        echo "- {$product->product_name} (Code: {$product->product_code})\n";
    }
    
    // Clean up test file
    unlink($testFile);
    echo "Cleaned up test file\n";
    Log::info("Cleaned up test file");
    
    Log::info('=== Comprehensive Import Test Completed Successfully ===');
    echo "Comprehensive import test completed successfully!\n";
    
} catch (Exception $e) {
    echo "Error during import: " . $e->getMessage() . "\n";
    Log::error('Error during import: ' . $e->getMessage());
    Log::error('Trace: ' . $e->getTraceAsString());
    
    // Clean up test file if it exists
    if (file_exists('comprehensive_test.csv')) {
        unlink('comprehensive_test.csv');
        echo "Cleaned up test file after error\n";
    }
    
    echo "Check laravel.log for more details.\n";
}
?>