{{-- resources/views/admin/dashboard.blade.php --}}
@extends('admin.layouts.sidebar')

@section('title', 'Dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
@endpush

@section('content')
<div>
    <!-- Welcome Card -->
    <div class="welcome-card">
        <div class="welcome-title">
            Selamat Datang, {{ Auth::user()->name }}! 👋
        </div>
        <div class="welcome-date">
            {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon menu">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </div>
            <div class="stat-number">{{ $totalMenu ?? 0 }}</div>
            <div class="stat-label">Total Menu</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon order">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
            <div class="stat-number">{{ $totalPesanan ?? 0 }}</div>
            <div class="stat-label">Total Pesanan</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon reservasi">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="stat-number">{{ $totalReservasi ?? 0 }}</div>
            <div class="stat-label">Total Reservasi</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon testimoni">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
            </div>
            <div class="stat-number">{{ $totalTestimoni ?? 0 }}</div>
            <div class="stat-label">Testimoni</div>
        </div>
    </div>
    
    <!-- Charts -->
    <div class="two-columns" style="grid-template-columns: repeat(2, 1fr);">
        <!-- Chart Pesanan -->
        <div class="chart-card">
            <div class="chart-title">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Statistik Pesanan Bulanan
            </div>
            <div class="bar-chart-container">
                <div class="bar-chart-wrapper">
                    <div class="custom-bar-chart" id="orderChart">
                        <!-- Bar chart akan diisi dengan JavaScript -->
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Chart Keuangan -->
        <div class="chart-card">
            <div class="chart-title">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Statistik Keuangan Bulanan (Rp)
            </div>
            <div class="bar-chart-container">
                <div class="bar-chart-wrapper">
                    <div class="custom-bar-chart" id="revenueChart">
                        <!-- Bar chart akan diisi dengan JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Orders & Reservations -->
    <div class="two-columns">
        <!-- Recent Orders -->
        <div class="recent-card">
            <div class="recent-header">
                <h3>
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    Pesanan Terbaru
                </h3>
                <a href="{{ route('admin.pesanan') }}" class="view-all">Lihat Semua →</a>
            </div>
            @forelse($latestOrders ?? [] as $order)
            <div class="recent-item">
                <div class="recent-info">
                    <div class="recent-name">{{ $order->customer_name }}</div>
                    <div class="recent-detail">{{ $order->order_number }}</div>
                </div>
                <div>
                    <span class="recent-status status-{{ $order->status }}">
                        {{ $order->status == 'pending' ? 'Menunggu' : ($order->status == 'processed' ? 'Diproses' : ($order->status == 'completed' ? 'Selesai' : 'Dibatalkan')) }}
                    </span>
                </div>
            </div>
            @empty
            <div class="empty-state">Belum ada pesanan</div>
            @endforelse
        </div>
    
    <!-- Recent Reservations & Testimonials -->
    <div class="two-columns">
        <!-- Recent Reservations -->
        <div class="recent-card">
            <div class="recent-header">
                <h3>
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Reservasi Terbaru
                </h3>
                <a href="{{ route('admin.reservasi') }}" class="view-all">Lihat Semua →</a>
            </div>
            @forelse($latestReservations ?? [] as $reservasi)
            <div class="recent-item">
                <div class="recent-info">
                    <div class="recent-name">{{ $reservasi->name }}</div>
                    <div class="recent-detail">{{ \Carbon\Carbon::parse($reservasi->date)->format('d/m/Y') }} - {{ $reservasi->time }} WIB</div>
                </div>
                <div>
                    <span class="recent-status status-{{ $reservasi->status }}">
                        {{ $reservasi->status == 'pending' ? 'Menunggu' : ($reservasi->status == 'confirmed' ? 'Dikonfirmasi' : 'Dibatalkan') }}
                    </span>
                </div>
            </div>
            @empty
            <div class="empty-state">Belum ada reservasi</div>
            @endforelse
        </div>
    </div>
    
    <!-- Testimonials -->
    <div class="two-columns" style="grid-template-columns: 1fr; margin-top: 1.5rem;">
        <!-- Testimonials -->
        <div class="recent-card">
            <div class="recent-header">
                <h3>
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    Testimoni Terbaru
                </h3>
                <a href="{{ route('admin.testimonial') }}" class="view-all">Lihat Semua →</a>
            </div>
            <div class="testimoni-grid">
                @forelse($testimonies ?? [] as $testimoni)
                <div class="testimoni-card">
                    <div class="testimoni-rating">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $testimoni->rating) ★ @else ☆ @endif
                        @endfor
                    </div>
                    <div class="testimoni-text">"{{ Str::limit($testimoni->message, 80) }}"</div>
                    <div class="testimoni-author">- {{ $testimoni->name }}</div>
                </div>
                @empty
                <div class="empty-state" style="grid-column: span 2;">Belum ada testimoni</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
    // Data chart dari controller
    const chartData = @json($chartData ?? array_fill(0, 12, 0));
    const revenueData = @json($revenueData ?? array_fill(0, 12, 0));
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    
    // Cari nilai maksimum untuk skala
    const maxOrderValue = Math.max(...chartData, 1);
    const maxRevenueValue = Math.max(...revenueData, 100000); // minimal skala 100k
    
    // Format uang rupiah
    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(number);
    }
    
    // Format angka pendek untuk label bar (misal: 1jt, 500rb)
    function formatShort(number) {
        if (number >= 1000000) {
            return (number / 1000000).toFixed(1).replace(/\.0$/, '') + 'jt';
        } else if (number >= 1000) {
            return (number / 1000).toFixed(0) + 'rb';
        }
        return number;
    }
    
    function renderCharts() {
        const orderContainer = document.getElementById('orderChart');
        const revenueContainer = document.getElementById('revenueChart');
        
        if (orderContainer) {
            let orderHtml = '';
            chartData.forEach((value, index) => {
                const barHeight = value > 0 ? (value / maxOrderValue) * 200 : 4;
                const displayValue = value > 0 ? value : 0;
                
                orderHtml += `
                    <div class="bar-item" title="${months[index]}: ${value} Pesanan">
                        <div class="bar" style="height: ${barHeight}px; position: relative;">
                            ${value > 0 ? `<div class="bar-value" style="font-size: 0.8rem;">${displayValue}</div>` : ''}
                        </div>
                        <div class="bar-label">${months[index]}</div>
                    </div>
                `;
            });
            orderContainer.innerHTML = orderHtml;
        }
        
        if (revenueContainer) {
            let revenueHtml = '';
            revenueData.forEach((value, index) => {
                const barHeight = value > 0 ? (value / maxRevenueValue) * 200 : 4;
                const shortValue = value > 0 ? formatShort(value) : 0;
                const tooltipValue = formatRupiah(value);
                
                revenueHtml += `
                    <div class="bar-item" title="${months[index]}: ${tooltipValue}">
                        <div class="bar" style="height: ${barHeight}px; position: relative; background: linear-gradient(180deg, #10b981 0%, #059669 100%);">
                            ${value > 0 ? `<div class="bar-value" style="font-size: 0.7rem; color: #059669;">${shortValue}</div>` : ''}
                        </div>
                        <div class="bar-label">${months[index]}</div>
                    </div>
                `;
            });
            revenueContainer.innerHTML = revenueHtml;
        }
    }
    
    // Render chart saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        renderCharts();
    });
    
    // Responsif: update chart saat window resize
    window.addEventListener('resize', function() {
        renderCharts();
    });
</script>
@endsection