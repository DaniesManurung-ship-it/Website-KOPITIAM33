<?php
// app/Http/Controllers/Admin/MenuSpesialController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuSpesial;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuSpesialController extends Controller
{
    public function index()
    {
        $spesialMenus = MenuSpesial::with('menu')->orderBy('is_featured', 'desc')  // mengambil data menu spesial dengan relasi menu, urutkan yang unggulan dulu
            ->orderBy('created_at', 'desc')
            ->get();
        $menus = Menu::all();
        return view('admin.menu_spesial', compact('spesialMenus', 'menus'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id|unique:menu_spesials,menu_id',
            'is_featured' => 'boolean',
        ]);
        
        MenuSpesial::create([
            'menu_id' => $request->menu_id,
            'is_featured' => $request->is_featured ? true : false,
            'is_active' => true,
            'user_id' => Auth::id(),
        ]);
        
        return redirect()->route('admin.menu-spesial')
            ->with('success', 'Menu spesial berhasil ditambahkan!');
    }
    
    public function edit($id)
    {
        $menu = MenuSpesial::with('menu')->findOrFail($id);
        return response()->json([
            'id' => $menu->id,
            'menu_id' => $menu->menu_id,
            'is_featured' => $menu->is_featured,
            'is_active' => $menu->is_active,
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $menu = MenuSpesial::findOrFail($id);
        
        $request->validate([
            'menu_id' => 'required|exists:menus,id|unique:menu_spesials,menu_id,' . $id,
            'is_featured' => 'boolean',
        ]);
        
        $menu->update([
            'menu_id' => $request->menu_id,
            'is_featured' => $request->is_featured ? true : false,
        ]);
        
        return redirect()->route('admin.menu-spesial')
            ->with('success', 'Menu spesial berhasil diupdate!');
    }
    
    public function destroy($id)
    {
        
        $menu = MenuSpesial::findOrFail($id);
        $menu->delete();
        
        return redirect()->route('admin.menu-spesial')
            ->with('success', 'Menu spesial berhasil dihapus!');
    }
    
    public function toggleFeatured($id)
    {
        $menu = MenuSpesial::findOrFail($id);

        // Jika mau dijadikan unggulan, nonaktifkan unggulan lain dulu
        // Menampilkan hanya satu menu unggulan
        if (!$menu->is_featured) {
            MenuSpesial::where('is_featured', true)->update(['is_featured' => false]);
        }
        
        // Hanya 1 menu yang bisa menjadi unggulan (is_featured = true) dalam satu waktu.
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