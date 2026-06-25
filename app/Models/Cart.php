<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';
    protected $fillable = [
        'user_id',
        'item_id',
        'item_type',
        'name',
        'price',
        'quantity',
        'image',
        'metadata'
    ];
    
    protected $casts = [
        'metadata' => 'array'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
