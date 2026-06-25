<?php
// app/Models/Menu.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'description', 'price', 'category', 'is_special_menu', 'image', 'badge', 'is_featured', 'is_available', 'user_id'
    ];
    
    protected $casts = [
        'price' => 'integer',
        'is_featured' => 'boolean',
        'is_available' => 'boolean',
        'is_special_menu' => 'boolean',
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

        if (str_starts_with($this->image, 'uploads/')) {
            return asset($this->image);
        }
        
        return asset('storage/' . $this->image);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}