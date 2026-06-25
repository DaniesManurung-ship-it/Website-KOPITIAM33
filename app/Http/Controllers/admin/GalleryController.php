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
            'images' => 'required|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category' => 'required|string',
            'description' => 'nullable|string'
        ]);
        
        $imagePaths = [];
        $firstImage = null;
        
        if ($request->hasFile('images')) {
            $destinationPath = public_path('uploads/gallery');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            
            foreach($request->file('images') as $index => $file) {
                $filename = time() . '_' . $index . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $filename);
                $path = 'uploads/gallery/' . $filename;
                $imagePaths[] = $path;
                
                if ($index === 0) {
                    $firstImage = $path;
                }
            }
            
            Gallery::create([
                'title' => $request->title,
                'image' => $firstImage, // Backward compatibility
                'images' => $imagePaths, // New JSON column
                'category' => $request->category,
                'description' => $request->description,
            ]);
        }
        
        return redirect()->route('admin.gallery')->with('success', 'Galeri berhasil ditambahkan!');
    }
    
    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        
        // Hapus file gambar dari public/uploads
        if ($gallery->images && is_array($gallery->images)) {
            foreach($gallery->images as $imgPath) {
                if (file_exists(public_path($imgPath))) {
                    unlink(public_path($imgPath));
                }
            }
        } elseif ($gallery->image && file_exists(public_path($gallery->image))) {
            unlink(public_path($gallery->image));
        }
        
        $gallery->delete();
        
        return redirect()->route('admin.gallery')->with('success', 'Galeri berhasil dihapus!');
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
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);
        
        $data = [
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
        ];
        
        if ($request->hasFile('images')) {
            // Hapus gambar lama
            if ($gallery->images && is_array($gallery->images)) {
                foreach($gallery->images as $imgPath) {
                    if (file_exists(public_path($imgPath))) {
                        unlink(public_path($imgPath));
                    }
                }
            } elseif ($gallery->image && file_exists(public_path($gallery->image))) {
                unlink(public_path($gallery->image));
            }
            
            $imagePaths = [];
            $destinationPath = public_path('uploads/gallery');
            
            foreach($request->file('images') as $index => $file) {
                $filename = time() . '_' . $index . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $filename);
                $path = 'uploads/gallery/' . $filename;
                $imagePaths[] = $path;
                
                if ($index === 0) {
                    $data['image'] = $path; // Backward compatibility
                }
            }
            $data['images'] = $imagePaths;
        }
        
        $gallery->update($data);
        
        return redirect()->route('admin.gallery')->with('success', 'Galeri berhasil diupdate!');
    }
}