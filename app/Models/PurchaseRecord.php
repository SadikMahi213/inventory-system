<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseRecord extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'date',
        'product_id',
        'product_name',
        'model',
        'size',
        'color',
        'quality',
        'quantity',
        'unit',
        'unit_price',
        'total_price',
        'supplier_id',
        'payment_status',
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    
    public function costAnalysis()
    {
        return $this->hasOne(CostAnalysis::class);
    }
}
