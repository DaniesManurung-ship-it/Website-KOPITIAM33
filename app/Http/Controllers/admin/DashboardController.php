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
        
        // Data untuk chart pesanan (12 bulan terakhir)
        $chartData = [];
        // Data untuk statistik keuangan bulanan (pendapatan bersih dari pesanan selesai)
        $revenueData = [];
        
        for ($i = 1; $i <= 12; $i++) {
            // Jumlah pesanan per bulan
            $count = Order::whereMonth('created_at', $i)->whereYear('created_at', date('Y'))->count();
            $chartData[] = $count;
            
            // Pendapatan per bulan (hanya untuk pesanan yang selesai)
            $completedOrders = Order::whereMonth('created_at', $i)
                ->whereYear('created_at', date('Y'))
                ->where('status', 'completed')
                ->get();
                
            $monthlyRevenue = 0;
            foreach ($completedOrders as $order) {
                $monthlyRevenue += ($order->subtotal - ($order->discount_amount ?? 0));
            }
            $revenueData[] = $monthlyRevenue;
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
            'revenueData',
            'testimonies',
            'latestReservations',
            'latestOrders'
        ));
    }
}