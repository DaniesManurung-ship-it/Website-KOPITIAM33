<?php
// app/Http/Controllers/PromoController.php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Tambahkan image_url untuk setiap promo
        foreach ($promos as $promo) {
            $promo->image_url = $promo->image_url;
        }
        
        return view('promo', compact('promos'));
    }
}