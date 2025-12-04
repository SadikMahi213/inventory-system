<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'product_id',
        'purchase_quantity',
        'sales_quantity',
        'current_stock',
        'average_cost',
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
