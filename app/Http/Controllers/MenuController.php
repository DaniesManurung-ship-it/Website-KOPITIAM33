<?php
// app/Http/Controllers/MenuController.php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::where('is_available', true)->orderBy('is_featured', 'desc')->get();
        return view('menu', compact('menus'));
    }
    
    public function promo()
    {
        $promos = Menu::where('is_available', true)->where('badge', 'like', '%Diskon%')->get();
        return view('promo', compact('promos'));
    }
    
    public function spesial()
    {
        $spesial = Menu::where('is_available', true)->where('is_featured', true)->get();
        return view('menu_spesial', compact('spesial'));
    }
    
    // Simpan pesanan dari keranjang
    public function storeOrder(Request $request)
    {
        $cart = json_decode($request->cart, true);
        
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }
        
        $subtotal = 0;
        $items = [];
        
        foreach ($cart as $item) {
            $menu = Menu::find($item['id']);
            if ($menu && $menu->is_available) {
                $items[] = [
                    'id' => $menu->id,
                    'name' => $menu->name,
                    'price' => $menu->price,
                    'quantity' => $item['quantity'],
                    'image' => $menu->image
                ];
                $subtotal += $menu->price * $item['quantity'];
            }
        }
        
        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(6)),
            'customer_name' => Auth::user()->name,
            'customer_email' => Auth::user()->email,
            'customer_phone' => $request->phone ?? '',
            'items' => $items,
            'subtotal' => $subtotal,
            'status' => 'pending',
            'can_cancel' => true,
            'notes' => $request->notes ?? '',
        ]);
        
        // Clear cart setelah checkout
        // Cart di-handle oleh JavaScript (localStorage)
        
        return redirect()->route('orders.history')->with('success', 'Pesanan berhasil dibuat! Menunggu konfirmasi admin.');
    }
    
    // Riwayat pesanan customer
    public function orderHistory()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('order_history', compact('orders'));
    }
    
    // Batalkan pesanan
    public function cancelOrder($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('can_cancel', true)
            ->where('status', 'pending')
            ->firstOrFail();
        
        $order->status = 'cancelled';
        $order->can_cancel = false;
        $order->save();
        
        return redirect()->route('orders.history')->with('success', 'Pesanan berhasil dibatalkan!');
    }
}