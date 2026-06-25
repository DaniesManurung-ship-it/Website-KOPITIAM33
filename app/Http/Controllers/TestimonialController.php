<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class TestimonialController extends Controller
{
    // Tampilkan semua testimoni untuk halaman public
    public function index()
    {
        // Ambil semua testimoni tanpa filter, urutkan dari yang terbaru
        $testimonials = Testimonial::orderBy('created_at', 'desc')
            ->paginate(12);
        
        // Debug: cek apakah ada data
        \Log::info('Jumlah testimoni: ' . $testimonials->total());
        
        return view('testimonials', compact('testimonials'));
    }
    
    // Simpan testimoni baru (hanya untuk user login)
    public function store(Request $request)
    {
        // Pastikan user login
        if (!Auth::check()) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Silakan login terlebih dahulu'], 401);
            }
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        // Cek apakah user memiliki pesanan yang sudah selesai
        $hasCompletedOrder = Order::where('user_id', Auth::id())->where('status', 'completed')->exists();
        if (!$hasCompletedOrder) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Maaf, hanya pelanggan yang pernah melakukan pemesanan sampai selesai yang dapat memberikan testimoni.'], 403);
            }
            return redirect()->back()->with('error', 'Maaf, hanya pelanggan yang pernah melakukan pemesanan sampai selesai yang dapat memberikan testimoni.');
        }
        
        $request->validate([
            'message' => 'required|string|min:10|max:500',
            'rating' => 'required|integer|min:1|max:5',
        ]);
        
        // Simpan testimoni
        $testimonial = Testimonial::create([
            'user_id' => Auth::id(),
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'message' => $request->message,
            'rating' => $request->rating,
        ]);
        
        // Debug: cek apakah berhasil disimpan
        \Log::info('Testimoni berhasil disimpan: ', ['id' => $testimonial->id, 'name' => $testimonial->name]);
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true, 
                'message' => 'Terima kasih! Testimoni Anda telah terkirim.',
                'testimonial' => $testimonial
            ]);
        }
        
        return redirect()->back()->with('success', 'Terima kasih! Testimoni Anda telah terkirim.');
    }
    
    // ========== TAMBAHKAN METHOD UPDATE INI ==========
    /**
     * Update testimoni milik sendiri
     */
    public function update(Request $request, $id)
    {
        try {
            // Cari testimoni berdasarkan ID dan pastikan milik user yang login
            $testimonial = Testimonial::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();
            
            // Validasi input
            $request->validate([
                'rating' => 'required|integer|min:1|max:5',
                'message' => 'required|string|min:10|max:500',
            ]);
            
            // Update data
            $testimonial->rating = $request->rating;
            $testimonial->message = $request->message;
            $testimonial->save();
            
            \Log::info('Testimoni berhasil diupdate: ', ['id' => $testimonial->id, 'user_id' => Auth::id()]);
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Testimoni berhasil diperbarui!'
                ]);
            }
            
            return redirect()->back()->with('success', 'Testimoni berhasil diperbarui!');
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Testimoni tidak ditemukan atau bukan milik Anda'
            ], 404);
        } catch (\Exception $e) {
            \Log::error('Error update testimoni: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
    // ========== END METHOD UPDATE ==========
    
    // Hapus testimoni milik sendiri
    public function destroy($id)
    {
        $testimonial = Testimonial::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        $testimonial->delete();
        
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Testimoni berhasil dihapus!']);
        }
        
        return redirect()->back()->with('success', 'Testimoni berhasil dihapus!');
    }
    
    // Ambil data testimoni untuk dropdown 
    public function getLatestTestimonials()
    {
        return Testimonial::orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }
    
    // Menampilkan testimoni milik sendiri
    public function myTestimonials()
    {
        $testimonials = Testimonial::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('testimonial_history', compact('testimonials'));
    }
}