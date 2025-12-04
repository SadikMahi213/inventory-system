<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DashboardSetting extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'setting_key',
        'setting_value',
        'setting_type',
        'description',
    ];
    
    protected $casts = [
        'setting_value' => 'array',
    ];
}
