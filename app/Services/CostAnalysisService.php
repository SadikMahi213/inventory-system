<?php

namespace App\Services;

use App\Models\Product;
use App\Models\PurchaseRecord;
use App\Models\CostAnalysis;

class CostAnalysisService
{
    /**
     * Calculate final selling price based on additional costs
     *
     * @param PurchaseRecord $purchaseRecord
     * @param float $staffCost
     * @param float $shopCost
     * @param float $transportCost
     * @param float $otherExpense
     * @param float $markupPercentage
     * @return CostAnalysis
     */
    public function calculateCostAnalysis(PurchaseRecord $purchaseRecord, $staffCost = 0, $shopCost = 0, $transportCost = 0, $otherExpense = 0, $markupPercentage = 20)
    {
        $product = $purchaseRecord->product;
        
        // Calculate total additional costs
        $totalAdditionalCost = $staffCost + $shopCost + $transportCost + $otherExpense;
        
        // Calculate cost per unit
        $costPerUnit = $purchaseRecord->unit_price + ($totalAdditionalCost / $purchaseRecord->quantity);
        
        // Calculate final selling price with markup
        $finalSellingPrice = $costPerUnit * (1 + ($markupPercentage / 100));
        
        // Create or update cost analysis record
        $costAnalysis = CostAnalysis::firstOrNew(['purchase_record_id' => $purchaseRecord->id]);
        $costAnalysis->product_id = $product->id;
        $costAnalysis->staff_cost = $staffCost;
        $costAnalysis->shop_cost = $shopCost;
        $costAnalysis->transport_cost = $transportCost;
        $costAnalysis->other_expense = $otherExpense;
        $costAnalysis->total_additional_cost = $totalAdditionalCost;
        $costAnalysis->final_selling_price = $finalSellingPrice;
        $costAnalysis->save();
        
        return $costAnalysis;
    }
    
    /**
     * Update product unit price based on cost analysis
     *
     * @param CostAnalysis $costAnalysis
     * @return void
     */
    public function updateProductPrice(CostAnalysis $costAnalysis)
    {
        $product = $costAnalysis->product;
        $product->unit_price = $costAnalysis->final_selling_price;
        $product->save();
    }
}