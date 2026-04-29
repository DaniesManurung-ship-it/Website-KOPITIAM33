<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    
    // Hapus testimoni milik sendiri
    public function destroy($id)
    {
        $testimonial = Testimonial::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        $testimonial->delete();
        
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