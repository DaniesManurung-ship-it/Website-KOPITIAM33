<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Promo extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'menu_id', 'discount', 'start_date', 'end_date', 'is_active', 'user_id'
    ];
    
    protected $casts = [
        'discount' => 'integer',
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    protected $appends = [
        'name', 'description', 'original_price', 'image', 'category', 'image_url', 'final_price'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessors to delegate to Menu
    public function getNameAttribute()
    {
        return $this->menu ? $this->menu->name : 'Unknown Menu';
    }

    public function getDescriptionAttribute()
    {
        return $this->menu ? $this->menu->description : '';
    }

    public function getOriginalPriceAttribute()
    {
        return $this->menu ? $this->menu->price : 0;
    }

    public function getImageAttribute()
    {
        return $this->menu ? $this->menu->image : null;
    }

    public function getCategoryAttribute()
    {
        return $this->menu ? $this->menu->category : null;
    }
    
    // ========== PERBAIKAN: Cek apakah promo masih aktif berdasarkan tanggal ==========
    public function getIsStillActiveAttribute()
    {
        $now = Carbon::now();
        $startDate = Carbon::parse($this->start_date);
        $endDate = Carbon::parse($this->end_date);
        
        // Jika tanggal sudah melewati end_date -> TIDAK AKTIF
        if ($now > $endDate) {
            return false;
        }
        
        // Jika tanggal belum mencapai start_date -> TIDAK AKTIF
        if ($now < $startDate) {
            return false;
        }
        
        // Jika manual di-set false -> TIDAK AKTIF
        if (!$this->is_active) {
            return false;
        }
        
        return true;
    }
    
    // Scope untuk mengambil promo yang masih aktif (untuk query)
    public function scopeActive($query)
    {
        $now = Carbon::now();
        return $query->where('is_active', true)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now);
    }
    
    // Accessor untuk URL gambar
    public function getImageUrlAttribute()
    {
        return $this->menu ? $this->menu->image_url : asset('uploads/default/default-promo.jpg');
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
    
    // Format tanggal untuk ditampilkan
    public function getFormattedStartDateAttribute()
    {
        return Carbon::parse($this->start_date)->translatedFormat('d M Y');
    }
    
    public function getFormattedEndDateAttribute()
    {
        return Carbon::parse($this->end_date)->translatedFormat('d M Y');
    }
}