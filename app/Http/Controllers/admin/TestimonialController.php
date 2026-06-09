<?php
// app/Http/Controllers/Admin/TestimonialController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('created_at', 'desc')->get();
        $archivedCount = Testimonial::where('is_archived', true)->count();
        $activeCount = Testimonial::where('is_archived', false)->count();
        
        return view('admin.testimonial', compact('testimonials', 'archivedCount', 'activeCount'));
    }
    
    public function archive(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->is_archived = !$testimonial->is_archived;
        $testimonial->save();
        
        $status = $testimonial->is_archived ? 'diarsipkan' : 'dipulihkan';

        if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Testimoni berhasil {$status}!"
            ]);
        }
        
        return redirect()->route('admin.testimonial')->with('success', "Testimoni berhasil {$status}!");
    }
    
    public function destroy(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();
        
        if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Testimoni berhasil dihapus!'
            ]);
        }

        return redirect()->route('admin.testimonial')->with('success', 'Testimoni berhasil dihapus!');
    }
}