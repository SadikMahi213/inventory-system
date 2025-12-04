<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProfitLoss extends Model
{
    use HasFactory;
    
    protected $table = 'profit_losses';
    
    protected $fillable = [
        'total_sales',
        'total_purchase',
        'net_profit',
    ];
}
