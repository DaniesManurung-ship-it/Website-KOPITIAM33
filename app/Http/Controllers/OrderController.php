<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Menu;
use App\Models\Promo;
use App\Models\MenuSpesial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon; // TAMBAHKAN INI

class OrderController extends Controller
{
    public function history()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('order_history', compact('orders'));
    }
    
    public function store(Request $request)
    {
        try {
            $cart = $request->cart;
            
            \Log::info('Cart data:', ['cart' => $cart]);
            
            if (empty($cart)) {
                return response()->json(['success' => false, 'message' => 'Keranjang kosong!']);
            }
            
            $items = [];
            $subtotal = 0;
            $now = Carbon::now(); // TAMBAHKAN: waktu sekarang
            
            foreach ($cart as $item) {
                // Cek apakah ini item promo
                if (isset($item['is_promo']) && $item['is_promo'] === true) {
                    $promo = Promo::find($item['id']);
                    
                    // ========== PERBAIKAN: Cek promo masih berlaku ==========
                    if ($promo && $promo->is_active) {
                        $startDate = Carbon::parse($promo->start_date);
                        $endDate = Carbon::parse($promo->end_date);
                        
                        // Cek apakah promo masih dalam periode berlaku
                        if ($now >= $startDate && $now <= $endDate) {
                            $finalPrice = $promo->original_price - ($promo->original_price * $promo->discount / 100);
                            $itemData = [
                                'id' => $promo->id,
                                'name' => $promo->name,
                                'price' => (int) $finalPrice,
                                'quantity' => (int) $item['quantity'],
                                'image' => $promo->image,
                                'type' => 'promo',
                                'original_price' => $promo->original_price,
                                'discount' => $promo->discount
                            ];
                            $items[] = $itemData;
                            $subtotal += $finalPrice * $item['quantity'];
                        } else {
                            // Promo sudah expired atau belum dimulai
                            $status = $now < $startDate ? 'belum dimulai' : 'sudah berakhir';
                            return response()->json([
                                'success' => false, 
                                'message' => "Promo {$promo->name} {$status}! Tidak dapat dipesan."
                            ], 400);
                        }
                    } else {
                        return response()->json([
                            'success' => false, 
                            'message' => "Promo tidak tersedia!"
                        ], 400);
                    }
                } 
                // Cek apakah ini item menu spesial
                elseif (isset($item['is_menu_spesial']) && $item['is_menu_spesial'] === true) {
                    $menuSpesial = MenuSpesial::find($item['id']);
                    if ($menuSpesial && $menuSpesial->is_active) {
                        $itemData = [
                            'id' => $menuSpesial->id,
                            'name' => $menuSpesial->name,
                            'price' => (int) $menuSpesial->price,
                            'quantity' => (int) $item['quantity'],
                            'image' => $menuSpesial->image,
                            'type' => 'menu_spesial',
                            'badge' => $menuSpesial->badge
                        ];
                        $items[] = $itemData;
                        $subtotal += $menuSpesial->price * $item['quantity'];
                    } else {
                        return response()->json([
                            'success' => false, 
                            'message' => "Menu Spesial tidak tersedia!"
                        ], 400);
                    }
                }
                // Menu biasa
                else {
                    $menu = Menu::find($item['id']);
                    if ($menu && $menu->is_available) {
                        $itemData = [
                            'id' => $menu->id,
                            'name' => $menu->name,
                            'price' => (int) $menu->price,
                            'quantity' => (int) $item['quantity'],
                            'image' => $menu->image,
                            'type' => 'menu'
                        ];
                        $items[] = $itemData;
                        $subtotal += $menu->price * $item['quantity'];
                    } else {
                        return response()->json([
                            'success' => false, 
                            'message' => "Menu tidak tersedia!"
                        ], 400);
                    }
                }
            }
            
            if (empty($items)) {
                return response()->json(['success' => false, 'message' => 'Tidak ada item yang valid!']);
            }
            
            // ========== PERBAIKAN: Order number lebih rapi ==========
            $orderNumber = $this->generateOrderNumber();
            
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => $orderNumber,
                'customer_name' => Auth::user()->name,
                'customer_email' => Auth::user()->email,
                'items' => $items,
                'subtotal' => (int) $subtotal,
                'status' => 'pending',
                'can_cancel' => true,
            ]);
            
            \Log::info('Order created:', ['order' => $order->toArray()]);
            
            // ========== Hapus keranjang setelah order ==========
            // Kirim event untuk clear cart
            return response()->json([
                'success' => true, 
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'message' => 'Pesanan berhasil dibuat!'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Order creation error:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false, 
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
    
    // ========== TAMBAHKAN: Method untuk generate order number yang rapi ==========
    private function generateOrderNumber()
    {
        $date = date('ymd');
        $lastOrder = Order::whereDate('created_at', today())->count();
        $sequence = str_pad($lastOrder + 1, 3, '0', STR_PAD_LEFT);
        
        // Format: #240429-001 (lebih kecil dan rapi)
        return "#{$date}-{$sequence}";
    }
    
    public function cancel($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('can_cancel', true)
            ->where('status', 'pending')
            ->firstOrFail();
        
        $order->status = 'cancelled';
        $order->can_cancel = false;
        $order->save();
        
        return response()->json(['success' => true]);
    }
}