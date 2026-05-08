<?php
// app/Http/Controllers/NotificationController.php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $notifications->setCollection(
            $this->withOrderItems($notifications->getCollection())
        );
        
        $unreadCount = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();
        
        return view('notifications', compact('notifications', 'unreadCount'));
    }
    
    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        $notification->markAsRead();
        
        return response()->json(['success' => true]);
    }
    
    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);
        
        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca');
    }
    
    public function getUnreadCount()
    {
        $count = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();
        
        return response()->json(['count' => $count]);
    }
    
    public function getLatest()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $notifications = $this->withOrderItems($notifications);
        
        $unreadCount = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();
        
        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }

    private function withOrderItems($notifications)
    {
        $orderIds = $notifications
            ->where('type', 'order')
            ->pluck('reference_id')
            ->filter()
            ->unique()
            ->values();

        $orders = Order::whereIn('id', $orderIds)->get()->keyBy('id');

        return $notifications->map(function ($notification) use ($orders) {
            $orderedItems = [];

            if ($notification->type === 'order' && $notification->reference_id) {
                $order = $orders->get((int) $notification->reference_id);

                if ($order && is_array($order->items)) {
                    foreach ($order->items as $item) {
                        if (!empty($item['image'])) {
                            $orderedItems[] = [
                                'name' => $item['name'] ?? 'Menu',
                                'image' => $item['image'],
                                'quantity' => $item['quantity'] ?? 1,
                            ];
                        }
                    }
                }
            }

            $notification->setAttribute('ordered_items', $orderedItems);

            return $notification;
        });
    }
    
    public function destroy($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        $notification->delete();
        
        return response()->json(['success' => true]);
    }
}