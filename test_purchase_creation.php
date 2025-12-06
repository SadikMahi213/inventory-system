<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\PurchaseRecord;
use Illuminate\Support\Facades\DB;

try {
    echo "Testing manual purchase record creation with all fields...\n";
    
    // Count existing records
    $initialCount = DB::table('purchase_records')->count();
    echo "Initial purchase records count: $initialCount\n";
    
    // Create a test record with all fields
    $purchaseRecord = PurchaseRecord::create([
        'id' => null, // Will be auto-generated
        'date' => '2025-12-01',
        'invoice_no' => 'TEST-001',
        'product_id' => null,
        'product_name' => 'Test Product',
        'model' => 'Test Model',
        'size' => 'Large',
        'color_or_material' => 'Red',
        'quality' => 'Premium',
        'quantity' => 10.50,
        'unit' => 'pieces',
        'unit_price' => 25.99,
        'total_price' => 272.89,
        'supplier_id' => null,
        'payment_status' => 'due',
        'created_at' => null, // Will be auto-generated
        'updated_at' => null, // Will be auto-generated
    ]);
    
    echo "Created purchase record with ID: " . $purchaseRecord->id . "\n";
    
    // Count after creation
    $finalCount = DB::table('purchase_records')->count();
    echo "Final purchase records count: $finalCount\n";
    echo "Records added: " . ($finalCount - $initialCount) . "\n";
    
    echo "Manual creation test successful!\n";
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}