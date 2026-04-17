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
        
        // Tambahkan accessor image_url untuk setiap menu
        foreach ($menuSpesial as $menu) {
            $menu->image_url = $this->getImageUrl($menu->image);
        }
        
        $featuredMenu = $menuSpesial->where('is_featured', true)->first();
        $regularMenus = $menuSpesial->where('is_featured', false);
        
        return view('menu_spesial', compact('menuSpesial', 'featuredMenu', 'regularMenus'));
    }
    
    private function getImageUrl($image)
    {
        if (!$image) {
            return asset('uploads/default/default-menu.jpg');
        }
        if (filter_var($image, FILTER_VALIDATE_URL)) {
            return $image;
        }
        if (str_starts_with($image, '/storage/')) {
            return asset($image);
        }
        if (str_starts_with($image, 'uploads/')) {
            return asset($image);
        }
        return asset('storage/' . $image);
    }
}