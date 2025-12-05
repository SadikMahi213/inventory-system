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
    
    protected $casts = [
        'date' => 'date',
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];
    
    // Define allowed payment statuses
    public const PAYMENT_STATUS_PAID = 'paid';
    public const PAYMENT_STATUS_DUE = 'due';
    public const PAYMENT_STATUS_PARTIAL = 'partial';
    
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