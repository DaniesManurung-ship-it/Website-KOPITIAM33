<?php
// app/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    protected $table = 'orders';
    
    protected $fillable = [
        'user_id',
        'order_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'items',
        'subtotal',
        'status',
        'can_cancel',
        'notes'
    ];
    
    protected $casts = [
        'items' => 'array',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}