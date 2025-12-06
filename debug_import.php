<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Imports\PurchaseRecordsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseRecord;

try {
    echo "Debugging purchase records import...\n";
    
    // Check current table state
    $initialCount = DB::table('purchase_records')->count();
    echo "Current purchase records count: $initialCount\n";
    
    // Check if we can access the file
    if (!file_exists('test_debug.csv')) {
        echo "ERROR: test_debug.csv file not found!\n";
        exit(1);
    }
    
    echo "File found. Attempting to import...\n";
    
    // Try to import with detailed logging
    Excel::import(new PurchaseRecordsImport, 'test_debug.csv');
    
    echo "Import completed!\n";
    
    // Check final table state
    $finalCount = DB::table('purchase_records')->count();
    echo "Final purchase records count: $finalCount\n";
    echo "Records added: " . ($finalCount - $initialCount) . "\n";
    
    // Show recent records
    echo "\nRecent purchase records:\n";
    $records = PurchaseRecord::latest()->limit(5)->get();
    foreach ($records as $record) {
        echo "- Date: {$record->date}, Product: {$record->product_name}, Quantity: {$record->quantity}, Supplier ID: {$record->supplier_id}\n";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "TRACE: " . $e->getTraceAsString() . "\n";
}