<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\PurchaseRecord;
use App\Models\SalesRecord;
use App\Models\Stock;
use App\Models\ProfitLoss;
use Carbon\Carbon;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);
        
        // Create regular user
        User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);
        
        // Create suppliers
        $suppliers = Supplier::factory()->count(5)->create();
        
        // Create customers
        $customers = Customer::factory()->count(5)->create();
        
        // Create products
        $products = Product::factory()->count(20)->create();
        
        // Create purchase records
        foreach ($products as $product) {
            PurchaseRecord::factory()->create([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'model' => $product->model,
                'size' => $product->size,
                'color' => $product->color,
                'quality' => $product->quality,
                'unit' => $product->unit,
                'supplier_id' => $suppliers->random()->id,
            ]);
        }
        
        // Create sales records
        foreach ($products->take(15) as $product) {
            SalesRecord::factory()->create([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'customer_id' => $customers->random()->id,
            ]);
        }
        
        // Create stock records
        foreach ($products as $product) {
            Stock::factory()->create([
                'product_id' => $product->id,
            ]);
        }
        
        // Create profit & loss records
        foreach ($products->take(10) as $product) {
            ProfitLoss::factory()->create([
                'product_id' => $product->id,
            ]);
        }
    }
}
