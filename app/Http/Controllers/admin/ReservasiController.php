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
                $reservasi->edit_status = false;
                
                // Jika konfirmasi dan customer sudah memilih meja, simpan sebagai assigned_table
                if ($request->status == 'confirmed' && $reservasi->customer_reply) {
                    $reservasi->assigned_table = $reservasi->customer_reply;
                }
            } elseif ($request->status == 'pending') {
                $reservasi->edit_status = true;
            }
            
            $reservasi->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diubah',
                'status' => $reservasi->status,
                'edit_status' => $reservasi->edit_status
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error update status: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    // PERBAIKAN: Mengubah nama method dari archive menjadi destroy (sama seperti pesanan)
    public function destroy($id)
    {
        try {
            $reservasi = Reservation::findOrFail($id);
            $reservasi->status = 'archived';
            $reservasi->edit_status = false;
            $reservasi->save();
            
            return response()->json(['success' => true, 'message' => 'Reservasi telah diarsipkan']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    public function restore($id)
    {
        try {
            $reservasi = Reservation::findOrFail($id);
            $reservasi->status = 'pending';
            $reservasi->edit_status = true;
            $reservasi->save();
            
            return response()->json(['success' => true, 'message' => 'Reservasi berhasil dipulihkan']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    public function edit($id)
    {
        try {
            $reservasi = Reservation::findOrFail($id);
            return response()->json($reservasi);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Reservasi tidak ditemukan'], 404);
        }
    }
    
    public function update(Request $request, $id)
    {
        try {
            $reservasi = Reservation::findOrFail($id);
            
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'date' => 'required|date',
                'time' => 'required',
                'people' => 'required|integer|min:1',
                'table_type' => 'nullable|string',
                'floor' => 'nullable|string',
                'notes' => 'nullable|string'
            ]);
            
            $reservasi->update($validated);
            
            if (in_array($reservasi->status, ['confirmed', 'cancelled', 'completed', 'archived'])) {
                $reservasi->edit_status = false;
                $reservasi->save();
            }
            
            return redirect()->route('admin.reservasi')->with('success', 'Reservasi berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->route('admin.reservasi')->with('error', 'Gagal mengupdate reservasi: ' . $e->getMessage());
        }
    }
    
    public function bulkAction(Request $request)
    {
        try {
            $ids = explode(',', $request->ids);
            
            if (empty($ids)) {
                return redirect()->route('admin.reservasi')->with('error', 'Tidak ada data yang dipilih');
            }
            
            if ($request->action == 'archive') {
                Reservation::whereIn('id', $ids)->update(['status' => 'archived', 'edit_status' => false]);
                $message = count($ids) . ' reservasi berhasil diarsipkan!';
            } elseif ($request->action == 'confirm') {
                Reservation::whereIn('id', $ids)->update(['status' => 'confirmed', 'edit_status' => false]);
                $message = count($ids) . ' reservasi berhasil dikonfirmasi!';
            } elseif ($request->action == 'cancel') {
                Reservation::whereIn('id', $ids)->update(['status' => 'cancelled', 'edit_status' => false]);
                $message = count($ids) . ' reservasi berhasil dibatalkan!';
            } elseif ($request->action == 'restore') {
                Reservation::whereIn('id', $ids)->update(['status' => 'pending', 'edit_status' => true]);
                $message = count($ids) . ' reservasi berhasil dipulihkan!';
            } else {
                return redirect()->route('admin.reservasi')->with('error', 'Aksi tidak valid');
            }
            
            return redirect()->route('admin.reservasi')->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->route('admin.reservasi')->with('error', 'Gagal melakukan aksi: ' . $e->getMessage());
        }
    }
    
    public function export(Request $request)
    {
        try {
            $query = Reservation::orderBy('created_at', 'desc');
            
            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }
            
            $reservasis = $query->get();
            $filename = "reservasi_" . date('Y-m-d_His') . ".csv";
            $handle = fopen('php://temp', 'w+');
            
            // Header CSV
            fputcsv($handle, ['ID', 'Nama', 'Email', 'Telepon', 'Tanggal', 'Jam', 'Jumlah Orang', 'Tipe Meja', 'Lantai', 'Catatan', 'Status', 'Bisa Edit', 'Dibuat Pada']);
            
            // Data CSV
            foreach ($reservasis as $r) {
                fputcsv($handle, [
                    $r->id, 
                    $r->name, 
                    $r->email, 
                    $r->phone, 
                    $r->date, 
                    $r->time, 
                    $r->people,
                    $r->table_type ?? '-', 
                    $r->floor ?? '-', 
                    $r->notes ?? '-', 
                    $r->status,
                    $r->edit_status ? 'Ya' : 'Tidak', 
                    $r->created_at
                ]);
            }
            
            rewind($handle);
            $csvContent = stream_get_contents($handle);
            fclose($handle);
            
            return response($csvContent, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.reservasi')->with('error', 'Gagal mengexport data: ' . $e->getMessage());
        }
    }
    
    public function sendMessage(Request $request, $id)
    {
        try {
            $reservasi = Reservation::findOrFail($id);
            
            $request->validate([
                'admin_message' => 'required|string'
            ]);
            
            $reservasi->admin_message = $request->admin_message;
            $reservasi->save();
            
            // Create notification for customer
            if ($reservasi->user_id) {
                try {
                    \App\Models\Notification::create([
                        'user_id' => $reservasi->user_id,
                        'type' => 'reservation_message',
                        'title' => 'Pesan dari Admin (Reservasi Meja)',
                        'message' => 'Admin telah merespon reservasi Anda dan mengirimkan daftar meja yang tersedia. Silakan cek dan pilih meja Anda.',
                        'data' => [
                            'reservation_id' => $reservasi->id,
                            'icon' => '💬',
                        ],
                        'reference_id' => $reservasi->id,
                        'reference_type' => 'Reservation'
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Failed to create notification for admin message: ' . $e->getMessage());
                }
            }
            
            return response()->json([
                'success' => true, 
                'message' => 'Pesan daftar meja berhasil dikirim ke customer!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Gagal mengirim pesan: ' . $e->getMessage()
            ], 500);
        }
    }
}