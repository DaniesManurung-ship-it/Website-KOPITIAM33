<?php
// app/Models/Menu.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'description', 'price', 'category', 'image', 'badge', 'is_featured', 'is_available'
    ];
    
    protected $casts = [
        'price' => 'integer',
        'is_featured' => 'boolean',
        'is_available' => 'boolean',
    ];
    
    // Accessor untuk URL gambar
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('storage/default-menu.jpg');
        }
        
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        
        if (str_starts_with($this->image, '/storage/')) {
            return asset($this->image);
        }
        
        return asset('storage/' . $this->image);
    }
}