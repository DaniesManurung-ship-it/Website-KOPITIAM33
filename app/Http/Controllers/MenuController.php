<?php
// app/Http/Controllers/MenuController.php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::where('is_available', true)->orderBy('is_featured', 'desc')->get();
        
        // Proses image path untuk setiap menu
        foreach ($menus as $menu) {
            if ($menu->image && !str_starts_with($menu->image, 'http') && !str_starts_with($menu->image, '/storage/')) {
                $menu->image = asset($menu->image);
            }
        }
        
        return view('menu', compact('menus'));
    }
}