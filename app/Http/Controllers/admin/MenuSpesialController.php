<?php
// app/Http/Controllers/Admin/MenuSpesialController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuSpesial;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MenuSpesialController extends Controller
{
    public function index()
    {
        $spesialMenus = MenuSpesial::orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.menu_spesial', compact('spesialMenus'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:1000',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'badge' => 'nullable|string|max:50',
            'is_featured' => 'boolean',
        ]);
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('menu-spesial', $filename, 'public');
            
            MenuSpesial::create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'image' => '/storage/' . $path, // PERBAIKAN: Tambahkan /storage/ di depan
                'badge' => $request->badge,
                'is_featured' => $request->is_featured ? true : false,
                'is_active' => true,
            ]);
        }
        
        return redirect()->route('admin.menu-spesial')
            ->with('success', 'Menu spesial berhasil ditambahkan!');
    }
    
    public function edit($id)
    {
        $menu = MenuSpesial::findOrFail($id);
        return response()->json($menu);
    }
    
    public function update(Request $request, $id)
    {
        $menu = MenuSpesial::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'badge' => 'nullable|string|max:50',
            'is_featured' => 'boolean',
        ]);
        
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'badge' => $request->badge,
            'is_featured' => $request->is_featured ? true : false,
        ];
        
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($menu->image && file_exists(public_path($menu->image))) {
                unlink(public_path($menu->image));
            }
            
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('menu-spesial', $filename, 'public');
            $data['image'] = '/storage/' . $path; // PERBAIKAN: Tambahkan /storage/ di depan
        }
        
        $menu->update($data);
        
        return redirect()->route('admin.menu-spesial')
            ->with('success', 'Menu spesial berhasil diupdate!');
    }
    
    public function destroy($id)
    {
        $menu = MenuSpesial::findOrFail($id);
        
        // Hapus gambar
        if ($menu->image && file_exists(public_path($menu->image))) {
            unlink(public_path($menu->image));
        }
        
        $menu->delete();
        
        return redirect()->route('admin.menu-spesial')
            ->with('success', 'Menu spesial berhasil dihapus!');
    }
    
    public function toggleFeatured($id)
    {
        $menu = MenuSpesial::findOrFail($id);
        
        if (!$menu->is_featured) {
            MenuSpesial::where('is_featured', true)->update(['is_featured' => false]);
        }
        
        $menu->is_featured = !$menu->is_featured;
        $menu->save();
        
        return response()->json(['success' => true]);
    }
    
    public function toggleStatus($id)
    {
        $menu = MenuSpesial::findOrFail($id);
        $menu->is_active = !$menu->is_active;
        $menu->save();
        
        return response()->json(['success' => true]);
    }
}