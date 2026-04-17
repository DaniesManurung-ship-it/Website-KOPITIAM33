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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category' => 'required|string',
            'description' => 'nullable|string'
        ]);
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
            
            // SIMPAN KE PUBLIC/UPLOADS (bukan storage)
            $destinationPath = public_path('uploads/gallery');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $filename);
            $imagePath = 'uploads/gallery/' . $filename;
            
            Gallery::create([
                'title' => $request->title,
                'image' => $imagePath,
                'category' => $request->category,
                'description' => $request->description,
            ]);
        }
        
        return redirect()->route('admin.gallery')->with('success', 'Gambar berhasil ditambahkan!');
    }
    
    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        
        // Hapus file gambar dari public/uploads
        if ($gallery->image && file_exists(public_path($gallery->image))) {
            unlink(public_path($gallery->image));
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
        
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($gallery->image && file_exists(public_path($gallery->image))) {
                unlink(public_path($gallery->image));
            }
            
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/gallery');
            $file->move($destinationPath, $filename);
            $data['image'] = 'uploads/gallery/' . $filename;
        }
        
        $gallery->update($data);
        
        return redirect()->route('admin.gallery')->with('success', 'Gambar berhasil diupdate!');
    }
}