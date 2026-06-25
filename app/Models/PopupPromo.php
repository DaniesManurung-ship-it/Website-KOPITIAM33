<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PopupPromo extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'voucher_code',
        'discount_percent',
        'is_active',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}
