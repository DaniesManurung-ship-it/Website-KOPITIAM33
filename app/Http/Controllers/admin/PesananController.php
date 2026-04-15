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
        // Admin TIDAK melihat pesanan yang status 'archived'
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
        
        return view('admin.pesanan', compact('pesanans'));
    }
    
    public function updateStatus(Request $request, $id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->status = $request->status;
            $order->save();
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    // ADMIN "MENGHAPUS" = MENGUBAH STATUS MENJADI 'archived'
    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);
            
            // TIDAK menghapus data! Hanya mengubah status
            $order->status = 'archived';
            $order->save();
            
            return response()->json(['success' => true, 'message' => 'Pesanan telah diarsipkan']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    // MEMULIHKAN pesanan yang diarsipkan
    public function restore($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->status = 'pending';
            $order->save();
            
            return response()->json(['success' => true, 'message' => 'Pesanan berhasil dipulihkan']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}