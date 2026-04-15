<?php
// app/Http/Controllers/TestimonialController.php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string|min:10|max:500',
                'rating' => 'required|integer|min:1|max:5',
            ]);
            
            $testimonial = Testimonial::create([
                'user_id' => Auth::id(),
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'message' => $request->message,
                'rating' => $request->rating,
                'is_archived' => false,
            ]);
            
            return response()->json([
                'success' => true, 
                'message' => 'Terima kasih! Testimoni Anda telah terkirim.'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim testimoni: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function myTestimonials()
    {
        $testimonials = Testimonial::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('testimonial_history', compact('testimonials'));
    }
    
    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        $request->validate([
            'message' => 'required|string|min:10|max:500',
            'rating' => 'required|integer|min:1|max:5',
        ]);
        
        $testimonial->update([
            'message' => $request->message,
            'rating' => $request->rating,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Testimoni berhasil diperbarui!'
        ]);
    }
    
    public function destroy($id)
    {
        $testimonial = Testimonial::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        $testimonial->delete();
        
        return redirect()->back()->with('success', 'Testimoni berhasil dihapus!');
    }
}