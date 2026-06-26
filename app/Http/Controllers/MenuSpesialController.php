<?php
// app/Http/Controllers/MenuSpesialController.php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuSpesialController extends Controller
{
    public function index()
    {
        $menuSpesial = Menu::where('is_special_menu', true)
            ->where('is_available', true)
            ->orderByRaw("CASE WHEN badge IS NOT NULL AND badge != '' THEN 1 ELSE 0 END DESC")
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        
            // Memisahkan menu unggulan dan menu reguler
        $featuredMenu = $menuSpesial->where('is_featured', true)->first();
        $regularMenus = $menuSpesial->where('is_featured', false);
        
        return view('menu_spesial', compact('menuSpesial', 'featuredMenu', 'regularMenus'));
    }
}