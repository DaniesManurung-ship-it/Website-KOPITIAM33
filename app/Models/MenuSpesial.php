<?php
// app/Models/MenuSpesial.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuSpesial extends Model
{
    use HasFactory;
    
    protected $table = 'menu_spesials';
    
    protected $fillable = [
        'name', 'description', 'price', 'image', 'badge', 'is_featured', 'is_active'
    ];
    
    protected $casts = [
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];
    
    // Accessor untuk URL gambar yang benar
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('storage/default-menu.jpg');
        }
        
        // Jika sudah URL lengkap
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        
        // Jika sudah ada /storage/ di depan
        if (str_starts_with($this->image, '/storage/')) {
            return asset($this->image);
        }
        
        // Default: asset dengan storage
        return asset('storage/' . $this->image);
    }
    
    // Untuk mendapatkan path gambar yang disimpan di database
    public function getImagePathAttribute()
    {
        return $this->image;
    }
}