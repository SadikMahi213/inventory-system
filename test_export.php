<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use Illuminate\Support\Facades\DB;

try {
    echo "Testing product data export...\n";
    
    // Count products
    $productCount = Product::count();
    echo "Total products in database: $productCount\n";
    
    // Get first product to check structure
    $firstProduct = Product::first();
    if ($firstProduct) {
        echo "Sample product data:\n";
        echo "- Product Code: " . $firstProduct->product_code . "\n";
        echo "- Product Name: " . $firstProduct->product_name . "\n";
        echo "- Unit Qty: " . $firstProduct->unit_qty . "\n";
        echo "- Unit Rate: " . $firstProduct->unit_rate . "\n";
    } else {
        echo "No products found in database.\n";
    }
    
    echo "Export functionality is ready. Visit /products/export-data to download CSV.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}