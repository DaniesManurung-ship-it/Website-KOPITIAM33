<?php
// app/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Notification;
use App\Http\Controllers\Admin\AdminNotificationController;

class Order extends Model
{
    use HasFactory;
    
    protected $table = 'orders';
    
    protected $fillable = [
        'user_id',
        'order_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'table_number',
        'floor',
        'voucher_code',
        'discount_amount',
        'items',
        'subtotal',
        'status',
        'payment_status',
        'payment_proof',
        'cancel_status',
        'notes'
    ];
    
    protected $casts = [
        'items' => 'array',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Scope untuk pesanan pending
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
    
    // Scope untuk pesanan processed
    public function scopeProcessed($query)
    {
        return $query->where('status', 'processed');
    }
    
    // Scope untuk pesanan completed
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
    
    // Boot method untuk event
    protected static function boot()
    {
        parent::boot();
        
        // Event ketika order dibuat (baru)
        static::created(function ($order) {
            // Clear cache admin notification
            if (class_exists(AdminNotificationController::class)) {
                AdminNotificationController::clearCache();
            }
            
            // Kirim notifikasi ke admin? (opsional, bisa via websocket atau event)
        });
        
        // Event ketika order diupdate
        static::updated(function ($order) {
            // Clear cache admin notification
            if (class_exists(AdminNotificationController::class)) {
                AdminNotificationController::clearCache();
            }
            
            // Kirim notifikasi ke user jika status berubah
            if ($order->wasChanged('status')) {
                $oldStatus = $order->getOriginal('status');
                $newStatus = $order->status;
                
                // Hanya kirim notifikasi jika user_id ada dan status berubah ke status tertentu
                if ($order->user_id && in_array($newStatus, ['processed', 'completed', 'cancelled'])) {
                    $statusMessages = [
                        'processed' => 'sedang diproses',
                        'completed' => 'telah selesai. Terima kasih telah berbelanja!',
                        'cancelled' => 'telah dibatalkan',
                    ];
                    
                    $statusIcons = [
                        'processed' => '🔄',
                        'completed' => '✅',
                        'cancelled' => '❌'
                    ];
                    
                    if (isset($statusMessages[$newStatus])) {
                        $message = "Pesanan #{$order->order_number} {$statusMessages[$newStatus]}";
                        $title = "Update Status Pesanan";
                        
                        try {
                            Notification::create([
                                'user_id' => $order->user_id,
                                'type' => 'order',
                                'title' => $title,
                                'message' => $message,
                                'data' => [
                                    'order_id' => $order->id,
                                    'order_number' => $order->order_number,
                                    'old_status' => $oldStatus,
                                    'new_status' => $newStatus,
                                    'icon' => $statusIcons[$newStatus] ?? '📦'
                                ],
                                'reference_id' => $order->id,
                                'reference_type' => 'Order',
                                'is_read' => false
                            ]);
                        } catch (\Exception $e) {
                            \Log::error('Failed to create notification: ' . $e->getMessage());
                        }
                    }
                }
            }
        });
        
        // Event ketika order dihapus/diarchive
        static::deleted(function ($order) {
            if (class_exists(AdminNotificationController::class)) {
                AdminNotificationController::clearCache();
            }
        });
    }
    
    // Helper method untuk cek apakah pesanan bisa dibatalkan
    public function isCancellable()
    {
        return $this->can_cancel && $this->status === 'pending';
    }
    
    // Helper method untuk format status
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Menunggu',
            'processed' => 'Diproses',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            'archived' => 'Diarsipkan'
        ];
        
        return $labels[$this->status] ?? $this->status;
    }
    
    // Helper method untuk get status badge class
    public function getStatusBadgeClassAttribute()
    {
        $classes = [
            'pending' => 'status-pending',
            'processed' => 'status-processed',
            'completed' => 'status-completed',
            'cancelled' => 'status-cancelled',
            'archived' => 'status-archived'
        ];
        
        return $classes[$this->status] ?? 'status-default';
    }
    
    // Helper method untuk format payment status
    public function getPaymentStatusLabelAttribute()
    {
        $labels = [
            'unpaid' => 'Belum Dibayar',
            'awaiting_confirmation' => 'Menunggu Konfirmasi',
            'paid' => 'Lunas',
            'failed' => 'Gagal'
        ];
        
        return $labels[$this->payment_status] ?? $this->payment_status;
    }
    
    // Helper method untuk get payment status badge class
    public function getPaymentBadgeClassAttribute()
    {
        $classes = [
            'unpaid' => 'status-cancelled', // red
            'awaiting_confirmation' => 'status-pending', // orange
            'paid' => 'status-completed', // green
            'failed' => 'status-archived' // gray
        ];
        
        return $classes[$this->payment_status] ?? 'status-default';
    }
}