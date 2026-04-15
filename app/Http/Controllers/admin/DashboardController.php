<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Total data
        $totalMenu = Menu::count();
        $totalPesanan = Order::count();
        $totalReservasi = Reservation::count();
        $totalTestimoni = Testimonial::count();
        $totalCustomers = User::where('role', 'customer')->count();
        
        // Data untuk chart (12 bulan terakhir)
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $count = Order::whereMonth('created_at', $i)->whereYear('created_at', date('Y'))->count();
            $chartData[] = $count;
        }
        
        // 🔥 PERBAIKAN: Ambil semua testimoni, tidak hanya approved
        $testimonies = Testimonial::orderBy('created_at', 'desc')
            ->limit(4)
            ->get();
        
        // Reservasi terbaru
        $latestReservations = Reservation::orderBy('created_at', 'desc')->limit(5)->get();
        
        // Pesanan terbaru
        $latestOrders = Order::orderBy('created_at', 'desc')->limit(5)->get();
        
        return view('admin.dashboard', compact(
            'totalMenu',
            'totalPesanan', 
            'totalReservasi',
            'totalTestimoni',
            'totalCustomers',
            'chartData',
            'testimonies',
            'latestReservations',
            'latestOrders'
        ));
    }
}