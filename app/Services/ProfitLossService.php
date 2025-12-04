<?php

namespace App\Services;

use App\Models\Product;
use App\Models\PurchaseRecord;
use App\Models\SalesRecord;
use App\Models\ProfitLoss;
use Carbon\Carbon;

class ProfitLossService
{
    /**
     * Calculate profit and loss for a product
     *
     * @param Product $product
     * @return ProfitLoss
     */
    public function calculateProductProfitLoss(Product $product)
    {
        // Get total revenue from sales
        $totalRevenue = $product->salesRecords->sum('total_amount');
        
        // Get total cost of goods sold (COGS) from purchases
        $totalCOGS = $product->purchaseRecords->sum('total_price');
        
        // Create or update profit and loss record
        $profitLoss = ProfitLoss::firstOrNew(['product_id' => $product->id]);
        $profitLoss->revenue = $totalRevenue;
        $profitLoss->cogs = $totalCOGS;
        $profitLoss->net_profit = $totalRevenue - $totalCOGS;
        $profitLoss->report_date = Carbon::now();
        $profitLoss->save();
        
        return $profitLoss;
    }
    
    /**
     * Calculate overall profit and loss
     *
     * @return ProfitLoss
     */
    public function calculateOverallProfitLoss()
    {
        // Get total revenue from all sales
        $totalRevenue = SalesRecord::sum('total_amount');
        
        // Get total cost of goods sold (COGS) from all purchases
        $totalCOGS = PurchaseRecord::sum('total_price');
        
        // Create or update overall profit and loss record
        $profitLoss = ProfitLoss::firstOrNew(['product_id' => null]);
        $profitLoss->revenue = $totalRevenue;
        $profitLoss->cogs = $totalCOGS;
        $profitLoss->net_profit = $totalRevenue - $totalCOGS;
        $profitLoss->report_date = Carbon::now();
        $profitLoss->save();
        
        return $profitLoss;
    }
    
    /**
     * Add additional costs to profit and loss calculation
     *
     * @param ProfitLoss $profitLoss
     * @param float $staffCost
     * @param float $shopCost
     * @param float $transportCost
     * @param float $otherExpense
     * @return ProfitLoss
     */
    public function addAdditionalCosts(ProfitLoss $profitLoss, $staffCost = 0, $shopCost = 0, $transportCost = 0, $otherExpense = 0)
    {
        $profitLoss->staff_cost = $staffCost;
        $profitLoss->shop_cost = $shopCost;
        $profitLoss->transport_cost = $transportCost;
        $profitLoss->other_expense = $otherExpense;
        $profitLoss->total_expenses = $staffCost + $shopCost + $transportCost + $otherExpense;
        $profitLoss->net_profit = $profitLoss->revenue - $profitLoss->cogs - $profitLoss->total_expenses;
        $profitLoss->save();
        
        return $profitLoss;
    }
}