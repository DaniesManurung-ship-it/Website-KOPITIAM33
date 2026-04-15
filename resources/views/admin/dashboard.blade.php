{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard')

@push('styles')
<style>
    /* Welcome Section */
    .welcome-card {
        background: linear-gradient(135deg, var(--sage) 0%, var(--wood) 100%);
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .welcome-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    
    .welcome-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .welcome-date {
        font-size: 0.875rem;
        opacity: 0.9;
    }
    
    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    @media (min-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }
    
    .stat-card {
        background: white;
        border-radius: 1rem;
        padding: 1.25rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }
    
    .stat-icon.menu { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .stat-icon.order { background: linear-gradient(135deg, #3b82f6, #2563eb); }
    .stat-icon.reservasi { background: linear-gradient(135deg, #10b981, #059669); }
    .stat-icon.testimoni { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
    
    .stat-icon svg {
        width: 24px;
        height: 24px;
        color: white;
    }
    
    .stat-number {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--wood);
    }
    
    .stat-label {
        color: #6b7280;
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }
    
    /* Chart & Recent Section */
    .two-columns {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    @media (min-width: 1024px) {
        .two-columns {
            grid-template-columns: 1.5fr 1fr;
        }
    }
    
    .chart-card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    
    .chart-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--wood);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .chart-title svg {
        width: 20px;
        height: 20px;
        color: var(--sage);
    }
    
    /* Recent Items */
    .recent-card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    
    .recent-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .recent-header h3 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--wood);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .view-all {
        font-size: 0.7rem;
        color: var(--sage);
        text-decoration: none;
    }
    
    .view-all:hover {
        text-decoration: underline;
    }
    
    .recent-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f3f4f6;
    }
    
    .recent-item:last-child {
        border-bottom: none;
    }
    
    .recent-info {
        flex: 1;
    }
    
    .recent-name {
        font-weight: 500;
        color: #374151;
        font-size: 0.875rem;
    }
    
    .recent-detail {
        font-size: 0.7rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }
    
    .recent-status {
        padding: 0.25rem 0.6rem;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 500;
    }
    
    .status-pending { background: #fef3c7; color: #92400e; }
    .status-confirmed { background: #d1fae5; color: #065f46; }
    .status-processed { background: #dbeafe; color: #1e40af; }
    .status-completed { background: #d1fae5; color: #065f46; }
    .status-cancelled { background: #fee2e2; color: #991b1b; }
    
    /* Testimoni Section */
    .testimoni-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
        margin-top: 1rem;
    }
    
    @media (min-width: 768px) {
        .testimoni-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    .testimoni-card {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-radius: 1rem;
        padding: 1rem;
        position: relative;
    }
    
    .testimoni-card::before {
        content: '"';
        position: absolute;
        top: 0.5rem;
        right: 1rem;
        font-size: 3rem;
        color: rgba(0,0,0,0.1);
        font-family: serif;
    }
    
    .testimoni-rating {
        color: #fbbf24;
        font-size: 0.8rem;
        margin-bottom: 0.5rem;
    }
    
    .testimoni-text {
        font-size: 0.8rem;
        color: #374151;
        line-height: 1.5;
        margin-bottom: 0.5rem;
    }
    
    .testimoni-author {
        font-size: 0.7rem;
        color: var(--wood);
        font-weight: 500;
    }
    
    .empty-state {
        text-align: center;
        padding: 2rem;
        color: #6b7280;
    }
</style>
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
    
    <!-- Chart & Recent Orders -->
    <div class="two-columns">
        <!-- Chart -->
        <div class="chart-card">
            <div class="chart-title">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Statistik Pesanan Bulanan
            </div>
            <canvas id="orderChart" height="200"></canvas>
        </div>
        
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('orderChart')?.getContext('2d');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Jumlah Pesanan',
                    data: {{ json_encode($chartData ?? []) }},
                    borderColor: '#8BA888',
                    backgroundColor: 'rgba(139, 168, 136, 0.1)',
                    borderWidth: 2,
                    pointBackgroundColor: '#D97642',
                    pointBorderColor: '#fff',
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });
    }
</script>
@endsection