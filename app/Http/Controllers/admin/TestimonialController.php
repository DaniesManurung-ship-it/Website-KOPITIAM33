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
    
    public function archive($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->is_archived = !$testimonial->is_archived;
        $testimonial->save();
        
        $status = $testimonial->is_archived ? 'diarsipkan' : 'dipulihkan';
        return redirect()->route('admin.testimonial')->with('success', "Testimoni berhasil {$status}!");
    }
    
    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();
        
        return redirect()->route('admin.testimonial')->with('success', 'Testimoni berhasil dihapus!');
    }
}