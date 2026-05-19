{{-- resources/views/order_history.blade.php --}}
@extends('layouts.app')

@section('title', 'Riwayat Pesanan - Café Kopitiam33')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/order_history.css') }}">
@endpush

@section('content')
<!-- Header Section -->
<section class="order-header-section">
    <div class="container">
        <h1>📦 Riwayat Pesanan</h1>
        <p>Lihat status dan riwayat pemesanan Anda</p>
    </div>
</section>

<div class="history-container">
    @if(session('success'))
    <div class="alert-success">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif
    
    @if($orders->count() > 0)
        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">Semua</button>
                <button class="filter-btn" data-filter="pending">⏳ Menunggu</button>
                <button class="filter-btn" data-filter="processed">🔄 Diproses</button>
                <button class="filter-btn" data-filter="completed">✅ Selesai</button>
                <button class="filter-btn" data-filter="cancelled">❌ Dibatalkan</button>
            </div>
            <div class="total-count">
                Total: {{ $orders->count() }} pesanan
            </div>
        </div>
        
        <div id="ordersList">
            @foreach($orders as $order)
            @php
                // Format tanggal dengan jam yang benar sesuai waktu pemesanan
                $createdAt = \Carbon\Carbon::parse($order->created_at);
                $updatedAt = \Carbon\Carbon::parse($order->updated_at);
                
                // Set timezone ke Asia/Jakarta (WIB)
                $createdAt->setTimezone('Asia/Jakarta');
                $updatedAt->setTimezone('Asia/Jakarta');
            @endphp
            <div class="order-card" data-status="{{ $order->status }}" data-id="{{ $order->id }}">
                <div class="order-header">
                    <div>
                        <span class="order-number">{{ $order->order_number }}</span>
                        <div class="time-detail">
                            <span class="time-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $createdAt->translatedFormat('d F Y') }}
                            </span>
                            <span class="time-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $createdAt->format('H:i') }} WIB
                            </span>
                        </div>
                    </div>
                    <span class="status-{{ $order->status }}">
                        @if($order->status == 'pending') 
                            ⏳ Menunggu Diproses
                        @elseif($order->status == 'processed') 
                            🔄 Sedang Diproses
                        @elseif($order->status == 'completed') 
                            ✅ Selesai
                        @else 
                            ❌ Dibatalkan
                        @endif
                    </span>
                </div>
                
                <div class="order-items">
                    @foreach($order->items as $item)
                    <div class="order-item">
                        <div>
                            <div class="item-name">{{ $item['name'] }}</div>
                            <div class="item-quantity">Jumlah: {{ $item['quantity'] }}</div>
                        </div>
                        <div class="item-price">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</div>
                    </div>
                    @endforeach
                </div>
                
                <div class="order-footer">
                    <div class="order-total">
                        Total Pesanan: <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="action-buttons-group">
                        @if($order->status == 'pending' && isset($order->can_cancel) && $order->can_cancel)
                            <button class="btn-cancel" onclick="cancelOrder({{ $order->id }})">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Batalkan Pesanan
                            </button>
                        @elseif($order->status == 'pending')
                            <div class="status-message pending">
                                ⏳ Menunggu konfirmasi admin, tidak dapat dibatalkan
                            </div>
                        @elseif($order->status == 'processed')
                            <div class="status-message processed">
                                🔄 Pesanan sedang diproses, tidak dapat dibatalkan
                            </div>
                        @elseif($order->status == 'completed')
                            <div class="status-message confirmed">
                                ✅ Pesanan telah selesai. Terima kasih!
                            </div>
                            @if($updatedAt->diffInDays($createdAt) > 0)
                            <div class="status-message confirmed" style="font-size:0.7rem;">
                                Selesai pada: {{ $updatedAt->translatedFormat('d F Y H:i') }} WIB
                            </div>
                            @endif
                        @elseif($order->status == 'cancelled')
                            <div class="status-message cancelled">
                                ❌ Pesanan telah dibatalkan
                            </div>
                            @if($updatedAt->diffInDays($createdAt) > 0)
                            <div class="status-message cancelled" style="font-size:0.7rem;">
                                Dibatalkan pada: {{ $updatedAt->translatedFormat('d F Y H:i') }} WIB
                            </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if(method_exists($orders, 'links'))
            <div class="pagination">
                {{ $orders->links() }}
            </div>
        @endif
        
        <div class="text-center">
            <a href="{{ route('menu') }}" class="btn-order-again">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Pesan Lagi
            </a>
        </div>
    @else
        <div class="empty-state">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <h3>📭 Belum Ada Pesanan</h3>
            <p>Anda belum melakukan pemesanan di Kopitiam33</p>
            <a href="{{ route('menu') }}" class="btn-order-again">
                Mulai Belanja
            </a>
        </div>
    @endif
</div>

<script>
    function cancelOrder(id) {
        if(confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')) {
            const cancelBtn = event.target;
            const originalText = cancelBtn.innerHTML;
            
            cancelBtn.disabled = true;
            cancelBtn.innerHTML = '⏳ Memproses...';
            
            fetch(`/order/${id}/cancel`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if(data.success) {
                    alert('✅ Pesanan berhasil dibatalkan!');
                    location.reload();
                } else {
                    alert(data.message || '❌ Gagal membatalkan pesanan');
                    cancelBtn.disabled = false;
                    cancelBtn.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('⚠️ Terjadi kesalahan. Silakan coba lagi.');
                cancelBtn.disabled = false;
                cancelBtn.innerHTML = originalText;
            });
        }
    }
    
    // Filter functionality
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const filter = this.dataset.filter;
            
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const cards = document.querySelectorAll('.order-card');
            cards.forEach(card => {
                if (filter === 'all' || card.dataset.status === filter) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection