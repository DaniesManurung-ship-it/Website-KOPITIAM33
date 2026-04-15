<?php
// app/Http/Controllers/Admin/ReservasiController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReservasiController extends Controller
{
    public function index(Request $request)
    {
        // Admin TIDAK melihat reservasi yang status 'archived'
        $query = Reservation::where('status', '!=', 'archived')->orderBy('created_at', 'desc');
        
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('date', $request->date);
        }
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        $reservasis = $query->paginate(15);
        
        $statusCount = [
            'pending' => Reservation::where('status', 'pending')->count(),
            'confirmed' => Reservation::where('status', 'confirmed')->count(),
            'cancelled' => Reservation::where('status', 'cancelled')->count(),
            'completed' => Reservation::where('status', 'completed')->count(),
            'archived' => Reservation::where('status', 'archived')->count(),
            'total' => Reservation::where('status', '!=', 'archived')->count(),
        ];
        
        return view('admin.reservasi', compact('reservasis', 'statusCount'));
    }
    
    public function updateStatus(Request $request, $id)
    {
        try {
            $reservasi = Reservation::find($id);
            
            if (!$reservasi) {
                return response()->json(['success' => false, 'message' => 'Reservasi tidak ditemukan'], 404);
            }
            
            $reservasi->status = $request->status;
            
            if (in_array($request->status, ['confirmed', 'cancelled', 'completed', 'archived'])) {
                $reservasi->can_edit = false;
            } elseif ($request->status == 'pending') {
                $reservasi->can_edit = true;
            }
            
            $reservasi->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diubah',
                'status' => $reservasi->status,
                'can_edit' => $reservasi->can_edit
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    // ADMIN "MENGHAPUS" = MENGUBAH STATUS MENJADI 'archived'
    public function destroy($id)
    {
        try {
            $reservasi = Reservation::findOrFail($id);
            
            // TIDAK menghapus data! Hanya mengubah status menjadi archived
            $reservasi->status = 'archived';
            $reservasi->can_edit = false;
            $reservasi->save();
            
            return redirect()->route('admin.reservasi')->with('success', "Reservasi milik {$reservasi->name} telah diarsipkan!");
        } catch (\Exception $e) {
            return redirect()->route('admin.reservasi')->with('error', 'Gagal mengarsipkan reservasi: ' . $e->getMessage());
        }
    }
    
    // MEMULIHKAN reservasi yang diarsipkan
    public function restore($id)
    {
        try {
            $reservasi = Reservation::findOrFail($id);
            $reservasi->status = 'pending';
            $reservasi->can_edit = true;
            $reservasi->save();
            
            return redirect()->route('admin.reservasi')->with('success', "Reservasi milik {$reservasi->name} berhasil dipulihkan!");
        } catch (\Exception $e) {
            return redirect()->route('admin.reservasi')->with('error', 'Gagal memulihkan reservasi: ' . $e->getMessage());
        }
    }
    
    public function edit($id)
    {
        $reservasi = Reservation::findOrFail($id);
        return response()->json($reservasi);
    }
    
    public function update(Request $request, $id)
    {
        $reservasi = Reservation::findOrFail($id);
        $reservasi->update($request->all());
        
        if (in_array($request->status, ['confirmed', 'cancelled', 'completed', 'archived'])) {
            $reservasi->can_edit = false;
            $reservasi->save();
        }
        
        return redirect()->route('admin.reservasi')->with('success', 'Reservasi berhasil diupdate!');
    }
    
    public function bulkAction(Request $request)
    {
        $ids = explode(',', $request->ids);
        
        if ($request->action == 'delete') {
            // Archive instead of delete
            Reservation::whereIn('id', $ids)->update(['status' => 'archived', 'can_edit' => false]);
            $message = count($ids) . ' reservasi berhasil diarsipkan!';
        } elseif ($request->action == 'confirm') {
            Reservation::whereIn('id', $ids)->update(['status' => 'confirmed', 'can_edit' => false]);
            $message = count($ids) . ' reservasi berhasil dikonfirmasi!';
        } elseif ($request->action == 'cancel') {
            Reservation::whereIn('id', $ids)->update(['status' => 'cancelled', 'can_edit' => false]);
            $message = count($ids) . ' reservasi berhasil dibatalkan!';
        } elseif ($request->action == 'restore') {
            Reservation::whereIn('id', $ids)->update(['status' => 'pending', 'can_edit' => true]);
            $message = count($ids) . ' reservasi berhasil dipulihkan!';
        }
        
        return redirect()->route('admin.reservasi')->with('success', $message);
    }
    
    public function export(Request $request)
    {
        $query = Reservation::orderBy('created_at', 'desc');
        
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        $reservasis = $query->get();
        $filename = "reservasi_" . date('Y-m-d_His') . ".csv";
        $handle = fopen('php://temp', 'w+');
        
        fputcsv($handle, ['ID', 'Nama', 'Email', 'Telepon', 'Tanggal', 'Jam', 'Jumlah Orang', 'Tipe Meja', 'Lantai', 'Catatan', 'Status', 'Bisa Edit', 'Dibuat Pada']);
        
        foreach ($reservasis as $r) {
            fputcsv($handle, [
                $r->id, $r->name, $r->email, $r->phone, $r->date, $r->time, $r->people,
                $r->table_type ?? '-', $r->floor ?? '-', $r->notes ?? '-', $r->status,
                $r->can_edit ? 'Ya' : 'Tidak', $r->created_at
            ]);
        }
        
        rewind($handle);
        $csvContent = stream_get_contents($handle);
        fclose($handle);
        
        return response($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }
}