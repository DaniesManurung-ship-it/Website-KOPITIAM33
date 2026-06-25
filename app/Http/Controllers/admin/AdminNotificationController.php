<?php
// app/Http/Controllers/Admin/AdminNotificationController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Reservation;
use Illuminate\Support\Facades\Cache;

class AdminNotificationController extends Controller
{
    public function getCounts()
    {
        // Gunakan cache agar tidak query setiap saat
        $cacheKey = 'admin_notification_counts';
        
        $counts = Cache::remember($cacheKey, 60, function () {
            return [
                'new_orders' => Order::where('status', 'pending')->count(),
                'new_reservations' => Reservation::where('status', 'pending')->whereNull('customer_reply')->count(),
                'replied_reservations' => Reservation::where('status', 'pending')->whereNotNull('customer_reply')->count(),
                'processed_orders' => Order::where('status', 'processed')->count(),
                'completed_today' => Order::where('status', 'completed')
                    ->whereDate('updated_at', today())
                    ->count(),
            ];
        });
        
        return response()->json($counts);
    }
    
    // Clear cache when status changes
    public static function clearCache()
    {
        Cache::forget('admin_notification_counts');
    }
}