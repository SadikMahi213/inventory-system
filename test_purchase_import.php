<?php

require_once 'vendor/autoload.php';

use App\Imports\PurchaseRecordsImport;
use Maatwebsite\Excel\Facades\Excel;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Create a simple test to see if the import works
try {
    echo "Starting purchase records import test...\n";
    
    // Check if the CSV file exists
    if (file_exists('test_purchase_records.csv')) {
        echo "CSV file found\n";
        
        // Try to import the file using Laravel's Excel facade
        Excel::import(new PurchaseRecordsImport, 'test_purchase_records.csv');
        echo "Purchase records import completed successfully\n";
    } else {
        echo "CSV file not found\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>