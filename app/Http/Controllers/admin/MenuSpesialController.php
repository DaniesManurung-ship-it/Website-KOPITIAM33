<?php
// app/Http/Controllers/Admin/MenuSpesialController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuSpesialController extends Controller
{
    public function index()
    {
        // Mengambil menu dengan is_special_menu = true
        $spesialMenus = Menu::where('is_special_menu', true)
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.menu_spesial', compact('spesialMenus'));
    }
    
    public function toggleFeatured($id)
    {
        $menu = Menu::findOrFail($id);

        // Jika mau dijadikan unggulan, nonaktifkan unggulan lain yang berkategori Menu Spesial
        if (!$menu->is_featured) {
            Menu::where('is_special_menu', true)
                ->where('is_featured', true)
                ->update(['is_featured' => false]);
        }
        
        // Hanya 1 menu spesial yang bisa menjadi unggulan dalam satu waktu.
        $menu->is_featured = !$menu->is_featured;
        $menu->save();
        
        return response()->json(['success' => true]);
    }
    
    public function toggleStatus($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->is_available = !$menu->is_available;
        $menu->save();
        
        return response()->json(['success' => true]);
    }
}