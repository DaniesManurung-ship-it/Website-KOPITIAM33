<?php
// app/Models/Promo.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'image', 'description', 'discount', 'original_price', 'start_date', 'end_date', 'is_active'
    ];
    
    protected $casts = [
        'original_price' => 'integer',
        'discount' => 'integer',
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];
    
    // Accessor untuk URL gambar
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('uploads/default/default-promo.jpg');
        }
        
        // Jika sudah URL lengkap
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        
        // Jika sudah ada /storage/ di depan (data lama)
        if (str_starts_with($this->image, '/storage/')) {
            return asset($this->image);
        }
        
        // Jika sudah ada uploads/ di depan (data baru)
        if (str_starts_with($this->image, 'uploads/')) {
            return asset($this->image);
        }
        
        // Default
        return asset('storage/' . $this->image);
    }
    
    // Accessor untuk harga setelah diskon
    public function getFinalPriceAttribute()
    {
        $original = (int) $this->original_price;
        $discount = (int) $this->discount;
        return $original - ($original * $discount / 100);
    }
    
    // Accessor untuk format harga rupiah
    public function getFormattedOriginalPriceAttribute()
    {
        return 'Rp ' . number_format($this->original_price, 0, ',', '.');
    }
    
    public function getFormattedFinalPriceAttribute()
    {
        return 'Rp ' . number_format($this->final_price, 0, ',', '.');
    }
}