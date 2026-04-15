<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredMenus = Menu::where('is_available', true)
                            ->where('is_featured', true)
                            ->limit(4)
                            ->get();
        
        return view('home', compact('featuredMenus'));
    }
}