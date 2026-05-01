<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Carbon\Carbon;

class PromoController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        
        // HANYA tampilkan promo yang masih aktif berdasarkan tanggal
        $promos = Promo::active()
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('promo', compact('promos'));
    }
}