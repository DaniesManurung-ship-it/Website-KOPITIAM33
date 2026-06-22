<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Promo extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'description', 'image', 'discount', 'start_date', 'end_date', 'is_active', 'user_id'
    ];
    
    protected $casts = [
        'discount' => 'integer',
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    protected $appends = [
        'image_url'
    ];

    // Satu Promo dapat memiliki banyak menu
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
        
        // Jika admin mau menonaktifkan promo secara manual, tampa menunggu tanggal berakhir
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
        if (!$this->image) {
            return asset('storage/default-promo.jpg');
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