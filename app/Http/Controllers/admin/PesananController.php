<?php
// app/Http/Controllers/Admin/PesananController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::where('status', '!=', 'archived');
        
        if($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('customer_name', 'like', '%'.$request->search.'%')
                ->orWhere('customer_email', 'like', '%'.$request->search.'%')
                ->orWhere('order_number', 'like', '%'.$request->search.'%');
            });
        }
        
        if($request->status && $request->status != 'all') {
            $query->where('status', $request->status);
        }
        
        if($request->date) {
            $query->whereDate('created_at', $request->date);
        }
        
        $pesanans = $query->orderBy('created_at', 'desc')->paginate(10);
        
        $statusCount = [
            'total' => Order::where('status', '!=', 'archived')->count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processed' => Order::where('status', 'processed')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];
        
        return view('admin.pesanan', compact('pesanans', 'statusCount'));
    }
    
    public function updateStatus(Request $request, $id)
    {
        try {
            $order = Order::findOrFail($id);
            
            // Cek apakah pesanan sudah dibayar jika ingin diproses/selesai
            if (in_array($request->status, ['processed', 'completed']) && $order->payment_status !== 'paid') {
                return response()->json(['success' => false, 'message' => 'Pembayaran belum dikonfirmasi!'], 400);
            }
            
            $order->status = $request->status;
            
            // Update can_cancel based on status
            if ($request->status != 'pending') {
                $order->can_cancel = false;
            }
            
            $order->save();
            
            // Notifikasi sudah dihandle oleh Model Order via boot method
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    public function confirmPayment($id)
    {
        try {
            $order = Order::findOrFail($id);
            if ($order->payment_status !== 'awaiting_confirmation') {
                return response()->json(['success' => false, 'message' => 'Status pembayaran tidak valid.'], 400);
            }
            
            $order->payment_status = 'paid';
            $order->save();
            
            return response()->json(['success' => true, 'message' => 'Pembayaran berhasil dikonfirmasi.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->status = 'archived';
            $order->can_cancel = false;
            $order->save();
            
            return response()->json(['success' => true, 'message' => 'Pesanan telah diarsipkan']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    public function restore($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->status = 'pending';
            $order->can_cancel = true;
            $order->save();
            
            return response()->json(['success' => true, 'message' => 'Pesanan berhasil dipulihkan']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}