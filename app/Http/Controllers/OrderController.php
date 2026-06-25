<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            $request->validate([
                'table_number' => 'required|string',
                'floor' => 'required|string|in:Lantai 1,Lantai 2,Outdoor',
            ]);

            $cart = $request->cart;
            
            \Log::info('Cart data:', ['cart' => $cart]);
            
            if (empty($cart)) {
                return response()->json(['success' => false, 'message' => 'Keranjang kosong!']);
            }
            
            $items = [];
            $subtotal = 0;
            
            foreach ($cart as $item) {
                $menu = Menu::find($item['id']);
                if ($menu && $menu->is_available) {
                    $itemData = [
                        'id' => $menu->id,
                        'name' => $menu->name,
                        'price' => (int) $menu->price,
                        'quantity' => (int) $item['quantity'],
                        'image' => $menu->image,
                        'type' => 'menu',
                        'badge' => $menu->badge
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
            
            if (empty($items)) {
                return response()->json(['success' => false, 'message' => 'Tidak ada item yang valid!']);
            }
            
            $voucherCode = $request->voucher_code;
            $discountAmount = 0;
            $appliedVoucher = null;

            if ($voucherCode) {
                $popupPromo = \App\Models\PopupPromo::where('voucher_code', $voucherCode)
                    ->where('is_active', true)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now())
                    ->first();
                
                if ($popupPromo) {
                    $hasUsed = Order::where('user_id', Auth::id())
                        ->where('voucher_code', $voucherCode)
                        ->whereIn('status', ['pending', 'processing', 'completed'])
                        ->exists();

                    if (!$hasUsed) {
                        $discountAmount = ($subtotal * $popupPromo->discount_percent) / 100;
                        $appliedVoucher = $voucherCode;
                    } else {
                        return response()->json(['success' => false, 'message' => 'Anda sudah menggunakan voucher ini sebelumnya!']);
                    }
                } else {
                    return response()->json(['success' => false, 'message' => 'Kode voucher tidak valid atau sudah kadaluarsa!']);
                }
            }

            $orderNumber = $this->generateOrderNumber();
            
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => $orderNumber,
                'customer_name' => Auth::user()->name,
                'customer_email' => Auth::user()->email,
                'table_number' => $request->table_number,
                'floor' => $request->floor,
                'items' => $items,
                'subtotal' => (int) ($subtotal - $discountAmount),
                'voucher_code' => $appliedVoucher,
                'discount_amount' => (int) $discountAmount,
                'status' => 'pending',
                'can_cancel' => true,
            ]);
            
            \Log::info('Order created:', ['order' => $order->toArray()]);
            
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
    
    private function generateOrderNumber()
    {
        $date = date('ymd');
        $lastOrder = Order::whereDate('created_at', today())->count();
        $sequence = str_pad($lastOrder + 1, 3, '0', STR_PAD_LEFT);
        
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
    
    public function payment($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        // Jika sudah lunas atau menunggu konfirmasi, redirect ke history
        if (in_array($order->payment_status, ['paid', 'awaiting_confirmation'])) {
            return redirect()->route('orders.history')->with('success', 'Pesanan ini sudah dibayar atau sedang menunggu konfirmasi.');
        }
        
        return view('order_payment', compact('order'));
    }
    
    public function uploadPayment(Request $request, $id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        if (in_array($order->payment_status, ['paid', 'awaiting_confirmation'])) {
            return back()->with('error', 'Status pembayaran pesanan ini sudah tidak dapat diubah.');
        }
        
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // max 5MB
        ]);
        
        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $safeOrderNumber = str_replace('#', '', $order->order_number);
            $filename = time() . '_payment_' . $safeOrderNumber . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/payments');
            
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            
            $file->move($destinationPath, $filename);
            
            $order->payment_proof = 'uploads/payments/' . $filename;
            $order->payment_status = 'awaiting_confirmation';
            $order->save();
            
            return redirect()->route('orders.history')->with('success', 'Bukti pembayaran berhasil dikirim! Menunggu konfirmasi admin.');
        }
        
        return back()->with('error', 'Gagal mengupload bukti pembayaran.');
    }
}
