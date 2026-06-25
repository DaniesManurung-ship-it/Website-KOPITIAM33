<?php
// app/Models/Reservation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Notification;
use App\Http\Controllers\Admin\AdminNotificationController;

class Reservation extends Model
{
    use HasFactory;
    
    protected $table = 'reservations';
    
    protected $fillable = [
        'user_id',
        'name', 
        'email', 
        'phone', 
        'date', 
        'time', 
        'people', 
        'table_type', 
        'floor', 
        'notes', 
        'status',
        'edit_token',
        'can_edit',
        'admin_message',
        'customer_reply',
        'assigned_table'
    ];
    
    protected $casts = [
        'can_edit' => 'boolean',
        'date' => 'date',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function canBeEdited()
    {
        return $this->can_edit && $this->status === 'pending';
    }
    
    // Scope untuk reservasi pending
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
    
    // Scope untuk reservasi confirmed
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }
    
    // Scope untuk reservasi completed
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
    
    // Boot method untuk event
    protected static function boot()
    {
        parent::boot();
        
        // Event ketika reservasi dibuat (baru)
        static::created(function ($reservation) {
            // Clear cache admin notification
            if (class_exists(AdminNotificationController::class)) {
                AdminNotificationController::clearCache();
            }
        });
        
        // Event ketika reservasi diupdate
        static::updated(function ($reservation) {
            // Clear cache admin notification
            if (class_exists(AdminNotificationController::class)) {
                AdminNotificationController::clearCache();
            }
            
            // Kirim notifikasi ke user jika status berubah dan user_id ada
            if ($reservation->wasChanged('status') && $reservation->user_id) {
                $oldStatus = $reservation->getOriginal('status');
                $newStatus = $reservation->status;
                
                $statusMessages = [
                    'confirmed' => 'telah dikonfirmasi. Silakan datang tepat waktu!',
                    'cancelled' => 'telah dibatalkan',
                    'completed' => 'telah selesai. Terima kasih telah berkunjung!',
                ];
                
                $statusIcons = [
                    'confirmed' => '✅',
                    'cancelled' => '❌',
                    'completed' => '📋'
                ];
                
                if (isset($statusMessages[$newStatus])) {
                    $formattedDate = date('d/m/Y', strtotime($reservation->date));
                    $message = "Reservasi Anda untuk tanggal {$formattedDate} jam {$reservation->time} {$statusMessages[$newStatus]}";
                    $title = "Update Status Reservasi";
                    
                    try {
                        Notification::create([
                            'user_id' => $reservation->user_id,
                            'type' => 'reservation',
                            'title' => $title,
                            'message' => $message,
                            'data' => [
                                'reservation_id' => $reservation->id,
                                'date' => $reservation->date,
                                'time' => $reservation->time,
                                'old_status' => $oldStatus,
                                'new_status' => $newStatus,
                                'icon' => $statusIcons[$newStatus] ?? '📅'
                            ],
                            'reference_id' => $reservation->id,
                            'reference_type' => 'Reservation',
                            'is_read' => false
                        ]);
                    } catch (\Exception $e) {
                        \Log::error('Failed to create notification: ' . $e->getMessage());
                    }
                }
            }
        });
        
        // Event ketika reservasi dihapus/diarchive
        static::deleted(function ($reservation) {
            if (class_exists(AdminNotificationController::class)) {
                AdminNotificationController::clearCache();
            }
        });
    }
    
    // Helper method untuk format status
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Menunggu',
            'confirmed' => 'Dikonfirmasi',
            'cancelled' => 'Dibatalkan',
            'completed' => 'Selesai',
            'archived' => 'Diarsipkan'
        ];
        
        return $labels[$this->status] ?? $this->status;
    }
    
    // Helper method untuk get status badge class
    public function getStatusBadgeClassAttribute()
    {
        $classes = [
            'pending' => 'status-pending',
            'confirmed' => 'status-confirmed',
            'cancelled' => 'status-cancelled',
            'completed' => 'status-completed',
            'archived' => 'status-archived'
        ];
        
        return $classes[$this->status] ?? 'status-default';
    }
    
    // Helper method untuk format date
    public function getFormattedDateAttribute()
    {
        return $this->date ? date('d/m/Y', strtotime($this->date)) : '-';
    }
    
    // Helper method untuk format datetime lengkap
    public function getFormattedDateTimeAttribute()
    {
        if (!$this->date) return '-';
        return date('d/m/Y', strtotime($this->date)) . ' ' . $this->time . ' WIB';
    }
}