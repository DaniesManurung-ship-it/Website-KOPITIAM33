<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'image', 'description', 'discount', 'original_price', 'start_date', 'end_date', 'is_active'
    ];
}