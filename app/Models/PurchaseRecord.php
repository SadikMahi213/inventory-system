<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseRecord extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'date',
        'invoice_no',
        'product_id',
        'product_name',
        'model',
        'size',
        'color_or_material',
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
        'quantity' => 'decimal:2',
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