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

try {
    echo "Starting web import simulation...\n";
    
    // First, let's check what's in the products table before import
    echo "Products before import: " . DB::table('products')->count() . "\n";
    
    // Create a simple test CSV file with unique product codes
    $testData = [
        ['product_name', 'size', 'brand', 'grade', 'material', 'color', 'model_no', 'product_code', 'unit_qty', 'unit', 'unit_rate', 'total_buy', 'category', 'quantity', 'approximate_rate', 'authentication_rate', 'sell_rate'],
        ['Web Test Product 1', 'Small', 'Web Brand', 'A', 'Plastic', 'Green', 'WT-001', 'WTP001_UNIQUE', '20', 'piece', '3.50', '70.00', 'Web Category', '200', '3.00', '4.00', '6.00'],
        ['Web Test Product 2', 'Extra Large', 'Web Brand', 'C', 'Wood', 'Yellow', 'WT-002', 'WTP002_UNIQUE', '15', 'piece', '12.00', '180.00', 'Web Category', '75', '11.00', '13.00', '18.00'],
    ];
    
    $testFile = 'web_test_import.csv';
    $fp = fopen($testFile, 'w');
    foreach ($testData as $row) {
        fputcsv($fp, $row);
    }
    fclose($fp);
    
    echo "Created test CSV file\n";
    
    // Create an UploadedFile instance to simulate a web upload
    $uploadedFile = new UploadedFile(
        $testFile,
        'web_test_import.csv',
        'text/csv',
        null,
        true // Test mode
    );
    
    echo "Created UploadedFile instance\n";
    
    // Try to import the file using the same method as the web controller
    echo "Attempting to import using Excel::import...\n";
    Excel::import(new ProductsImport, $uploadedFile);
    
    echo "Import completed successfully!\n";
    
    // Check what's in the products table after import
    echo "Products after import: " . DB::table('products')->count() . "\n";
    
    // Clean up test file
    unlink($testFile);
    
} catch (Exception $e) {
    echo "Error during import: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
    
    // Clean up test file if it exists
    if (file_exists('web_test_import.csv')) {
        unlink('web_test_import.csv');
    }
}

?>