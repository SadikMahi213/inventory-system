<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'product_name',
        'size',
        'brand',
        'grade',
        'material',
        'color',
        'model_no',
        'product_code',
        'unit_qty',
        'unit',
        'unit_rate',
        'total_buy',
        'category_id',
        'quantity',
        'approximate_rate',
        'authentication_rate',
        'sell_rate',
        'is_featured',
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
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