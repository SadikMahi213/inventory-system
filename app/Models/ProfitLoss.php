<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProfitLoss extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'date',
        'total_sales',
        'total_purchase_cost',
        'operating_cost',
        'net_profit',
    ];
    
    protected $casts = [
        'date' => 'date',
        'total_sales' => 'decimal:2',
        'total_purchase_cost' => 'decimal:2',
        'operating_cost' => 'decimal:2',
        'net_profit' => 'decimal:2',
    ];
}