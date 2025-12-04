<?php

namespace App\Services;

use App\Models\Product;
use App\Models\PurchaseRecord;
use App\Models\SalesRecord;
use App\Models\Stock;

class StockService
{
    /**
     * Update stock when a purchase is made
     *
     * @param PurchaseRecord $purchaseRecord
     * @return void
     */
    public function updateStockFromPurchase(PurchaseRecord $purchaseRecord)
    {
        $product = $purchaseRecord->product;
        
        // Get or create stock record for the product
        $stock = Stock::firstOrCreate(
            ['product_id' => $product->id],
            [
                'purchase_quantity' => 0,
                'sales_quantity' => 0,
                'current_stock' => 0,
                'average_cost' => 0
            ]
        );
        
        // Update purchase quantity
        $stock->purchase_quantity += $purchaseRecord->quantity;
        $stock->current_stock += $purchaseRecord->quantity;
        
        // Update average cost
        $totalCost = ($stock->average_cost * ($stock->purchase_quantity - $purchaseRecord->quantity)) + 
                     ($purchaseRecord->unit_price * $purchaseRecord->quantity);
        $stock->average_cost = $totalCost / $stock->purchase_quantity;
        
        $stock->save();
    }
    
    /**
     * Update stock when a sale is made
     *
     * @param SalesRecord $salesRecord
     * @return void
     */
    public function updateStockFromSale(SalesRecord $salesRecord)
    {
        $product = $salesRecord->product;
        
        // Get stock record for the product
        $stock = Stock::where('product_id', $product->id)->first();
        
        if ($stock) {
            // Update sales quantity
            $stock->sales_quantity += $salesRecord->quantity;
            $stock->current_stock -= $salesRecord->quantity;
            
            // Ensure stock doesn't go negative
            if ($stock->current_stock < 0) {
                $stock->current_stock = 0;
            }
            
            $stock->save();
        }
    }
    
    /**
     * Get low stock items
     *
     * @param int $threshold
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getLowStockItems($threshold = 10)
    {
        return Stock::with('product')
            ->where('current_stock', '<=', $threshold)
            ->get();
    }
    
    /**
     * Get stock level for a product
     *
     * @param Product $product
     * @return int
     */
    public function getProductStockLevel(Product $product)
    {
        $stock = Stock::where('product_id', $product->id)->first();
        return $stock ? $stock->current_stock : 0;
    }
}