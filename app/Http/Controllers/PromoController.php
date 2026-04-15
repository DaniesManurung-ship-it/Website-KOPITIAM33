<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PromoController extends Controller
{
    public function index()
    {
        // Ambil semua promo yang aktif (tanpa filter tanggal untuk testing)
        $promos = Promo::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Debug: cek apakah data promo punya original_price
        // dd($promos);
        
        return view('promo', compact('promos'));
    }
}