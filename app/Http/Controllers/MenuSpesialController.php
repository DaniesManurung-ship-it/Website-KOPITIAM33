<?php
// app/Http/Controllers/MenuSpesialController.php

namespace App\Http\Controllers;

use App\Models\MenuSpesial;
use Illuminate\Http\Request;

class MenuSpesialController extends Controller
{
    public function index()
    {
        $menuSpesial = MenuSpesial::where('is_active', true)
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $featuredMenu = $menuSpesial->where('is_featured', true)->first();
        $regularMenus = $menuSpesial->where('is_featured', false);
        
        return view('menu_spesial', compact('menuSpesial', 'featuredMenu', 'regularMenus'));
    }
}