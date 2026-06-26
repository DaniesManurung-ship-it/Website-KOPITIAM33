<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $featuredMenus = Menu::where('is_available', true)
                            ->where('is_featured', true)
                            ->limit(4)
                            ->get();
        
        $popupPromo = \App\Models\PopupPromo::where('is_active', true)
                            ->whereDate('start_date', '<=', now())
                            ->whereDate('end_date', '>=', now())
                            ->first();

        return view('dashboard', compact('featuredMenus', 'popupPromo'));
    }
}