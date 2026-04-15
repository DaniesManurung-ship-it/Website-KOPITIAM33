<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class PesananReservasiController extends Controller
{
    public function index()
    {
        $reservasiMasuk = Reservation::where('status', 'pending')->orderBy('created_at', 'desc')->get();
        return view('admin.pesanan_reservasi', compact('reservasiMasuk'));
    }
    
    public function confirm($id)
    {
        $reservasi = Reservation::findOrFail($id);
        $reservasi->status = 'confirmed';
        $reservasi->save();
        
        return response()->json(['success' => true]);
    }

    // app/Http/Controllers/Admin/PesananController.php

public function restore($id)
{
    try {
        $order = Order::findOrFail($id);
        $order->status = 'pending'; // Kembalikan ke status pending
        $order->save();
        
        return response()->json(['success' => true, 'message' => 'Pesanan berhasil dipulihkan']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}
}