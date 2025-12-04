<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CostAnalysis extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'product_id',
        'purchase_record_id',
        'staff_cost',
        'shop_cost',
        'transport_cost',
        'other_expense',
        'total_additional_cost',
        'final_selling_price',
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function purchaseRecord()
    {
        return $this->belongsTo(PurchaseRecord::class);
    }
}
