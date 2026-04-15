<?php
// app/Http/Controllers/Admin/GalleryController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::orderBy('created_at', 'desc')->get();
        return view('admin.gallery', compact('galleries'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Validasi file gambar
            'category' => 'required|string',
            'description' => 'nullable|string'
        ]);
        
        // Upload gambar
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('gallery', $filename, 'public');
            
            Gallery::create([
                'title' => $request->title,
                'image' => '/storage/' . $path,
                'category' => $request->category,
                'description' => $request->description,
            ]);
        }
        
        return redirect()->route('admin.gallery')->with('success', 'Gambar berhasil ditambahkan!');
    }
    
    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        
        // Hapus file gambar dari folder
        $imagePath = public_path($gallery->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        
        $gallery->delete();
        
        return redirect()->route('admin.gallery')->with('success', 'Gambar berhasil dihapus!');
    }
    
    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);
        return response()->json($gallery);
    }
    
    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);
        
        $data = [
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
        ];
        
        // Upload gambar baru jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            $oldImagePath = public_path($gallery->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            
            // Upload gambar baru
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('gallery', $filename, 'public');
            $data['image'] = '/storage/' . $path;
        }
        
        $gallery->update($data);
        
        return redirect()->route('admin.gallery')->with('success', 'Gambar berhasil diupdate!');
    }
}