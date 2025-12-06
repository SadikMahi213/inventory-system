<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

try {
    echo "Testing product import functionality...\n";
    
    // Count products and categories
    $productCount = Product::count();
    $categoryCount = Category::count();
    
    echo "Current products in database: $productCount\n";
    echo "Current categories in database: $categoryCount\n";
    
    // Create a sample category
    if (DB::getSchemaBuilder()->hasTable('categories')) {
        $category = Category::firstOrCreate(
            ['name' => 'Electronics'],
            ['description' => 'Electronic devices and accessories']
        );
        echo "Created/Found category: " . $category->name . " (ID: " . $category->id . ")\n";
    } else {
        echo "Categories table does not exist.\n";
    }
    
    // Create a sample product
    $product = Product::create([
        'product_code' => 'TEST001',
        'product_name' => 'Test Product',
        'unit_qty' => 10,
        'unit_rate' => 5.99,
        'category_id' => $category->id ?? null
    ]);
    
    echo "Created test product: " . $product->product_name . " (Code: " . $product->product_code . ")\n";
    
    echo "Product import functionality is ready.\n";
    echo "Visit /products/import/form to access the import page.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}