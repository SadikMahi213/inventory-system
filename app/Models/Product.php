<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'product_code',
        'name',
        'model',
        'size',
        'color',
        'quality',
        'unit',
        'unit_price',
        'selling_price',
        'description',
        'is_featured',
    ];
    
    public function purchaseRecords()
    {
        return $this->hasMany(PurchaseRecord::class);
    }
    
    public function salesRecords()
    {
        return $this->hasMany(SalesRecord::class);
    }
    
    public function stock()
    {
        return $this->hasOne(Stock::class);
    }
    
    public function costAnalysis()
    {
        return $this->hasMany(CostAnalysis::class);
    }
    
    public function profitLoss()
    {
        return $this->hasMany(ProfitLoss::class);
    }
}
