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
        'menu_id', 'is_featured', 'is_active', 'user_id'
    ];
    
    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'name', 'description', 'price', 'image', 'badge', 'category', 'image_url'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Tidak perlu menabahkan menambahkan quary join manual, data, nama, harga akan otomatis diambil dari  
    public function getNameAttribute()
    {
        return $this->menu ? $this->menu->name : 'Unknown Menu';
    }

    public function getDescriptionAttribute()
    {
        return $this->menu ? $this->menu->description : '';
    }

    public function getPriceAttribute()
    {
        return $this->menu ? $this->menu->price : 0;
    }

    public function getImageAttribute()
    {
        return $this->menu ? $this->menu->image : null;
    }

    public function getBadgeAttribute()
    {
        return $this->menu ? $this->menu->badge : null;
    }

    public function getCategoryAttribute()
    {
        return $this->menu ? $this->menu->category : null;
    }

    // Accessor untuk URL gambar - SAMA PERSIS DENGAN MENU
    public function getImageUrlAttribute()
    {
        return $this->menu ? $this->menu->image_url : asset('uploads/default/default-menu.jpg');
    }
}