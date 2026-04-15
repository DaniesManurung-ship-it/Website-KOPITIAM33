{{-- resources/views/order_history.blade.php --}}
@extends('layouts.app')

@section('title', 'Riwayat Pesanan - Café Kopitiam33')

@push('styles')
<style>
    /* RESET & OVERRIDE - Sama seperti halaman cart */
    .order-header-section {
        background: #8BA888 !important;
        background-color: #8BA888 !important;
        color: white !important;
        padding: 3rem 0 !important;
        text-align: center !important;
    }
    
    .order-header-section h1 {
        font-family: 'Playfair Display', serif !important;
        font-size: 2.5rem !important;
        font-weight: 700 !important;
        margin-bottom: 0.5rem !important;
        color: white !important;
    }
    
    .order-header-section p {
        font-size: 1rem !important;
        max-width: 600px !important;
        margin: 0 auto !important;
        opacity: 0.9 !important;
        color: white !important;
    }
    
    /* Pastikan tidak ada gradient atau background lain yang mengganggu */
    .order-header-section::before,
    .order-header-section::after {
        display: none !important;
    }
    
    :root {
        --sage: #8BA888;
        --cream: #F5EFE6;
        --wood: #A67B5B;
        --accent: #D97642;
        --dark: #4A3728;
    }
    
    .container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    
    .history-container {
        max-width: 1280px;
        margin: 3rem auto;
        padding: 0 1rem;
    }
    
    /* Alert Success */
    .alert-success {
        background: #d1fae5;
        color: #065f46;
        padding: 1rem 1.25rem;
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.875rem;
        border-left: 4px solid #10b981;
    }
    
    .alert-success svg {
        width: 20px;
        height: 20px;
        flex-shrink: 0;
    }
    
    /* Filter Section */
    .filter-section {
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .filter-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .filter-btn {
        padding: 0.5rem 1.25rem;
        border-radius: 2rem;
        border: none;
        cursor: pointer;
        font-size: 0.8rem;
        font-weight: 500;
        transition: all 0.3s ease;
        background: #f3f4f6;
        color: #4b5563;
    }
    
    .filter-btn.active {
        background: var(--sage);
        color: white;
    }
    
    .filter-btn:hover:not(.active) {
        background: #e5e7eb;
        transform: translateY(-1px);
    }
    
    .total-count {
        font-size: 0.8rem;
        color: #6b7280;
        background: #f3f4f6;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
    }
    
    /* Order Card */
    .order-card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        border: 1px solid #f3f4f6;
    }
    
    .order-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        border-color: var(--sage);
    }
    
    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #f3f4f6;
        flex-wrap: wrap;
        gap: 0.75rem;
    }
    
    .order-number {
        font-weight: 700;
        color: var(--wood);
        font-size: 0.9rem;
        background: var(--cream);
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        display: inline-block;
    }
    
    .order-date {
        font-size: 0.7rem;
        color: #6b7280;
        margin-left: 0.5rem;
    }
    
    /* Status Badges */
    .status-pending, .status-processed, .status-completed, .status-cancelled {
        padding: 0.3rem 0.9rem;
        border-radius: 2rem;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }
    
    .status-pending {
        background: #FEF3C7;
        color: #92400E;
    }
    
    .status-processed {
        background: #DBEAFE;
        color: #1E40AF;
    }
    
    .status-completed {
        background: #D1FAE5;
        color: #065F46;
    }
    
    .status-cancelled {
        background: #FEE2E2;
        color: #991B1B;
    }
    
    /* Order Items */
    .order-items {
        margin-bottom: 1rem;
    }
    
    .order-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f3f4f6;
    }
    
    .order-item:last-child {
        border-bottom: none;
    }
    
    .item-name {
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
    }
    
    .item-quantity {
        font-size: 0.7rem;
        color: #6b7280;
        margin-top: 0.2rem;
    }
    
    .item-price {
        font-weight: 700;
        color: var(--accent);
        font-size: 0.875rem;
    }
    
    /* Order Footer */
    .order-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #f3f4f6;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .order-total {
        font-weight: 700;
        font-size: 1rem;
        color: var(--wood);
    }
    
    .order-total span {
        color: var(--accent);
        font-size: 1.25rem;
        font-weight: 800;
    }
    
    /* Cancel Button */
    .btn-cancel {
        background: #ef4444;
        color: white;
        padding: 0.5rem 1.25rem;
        border-radius: 0.5rem;
        border: none;
        cursor: pointer;
        font-size: 0.8rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .btn-cancel:hover {
        background: #dc2626;
        transform: translateY(-1px);
    }
    
    .btn-cancel:disabled {
        background: #e5e7eb;
        color: #6b7280;
        cursor: not-allowed;
        transform: none;
    }
    
    /* Status Message */
    .status-message {
        font-size: 0.8rem;
        padding: 0.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .status-message.confirmed {
        color: #10b981;
    }
    
    .status-message.cancelled {
        color: #ef4444;
    }
    
    .status-message.pending {
        color: #f59e0b;
    }
    
    .status-message.processed {
        color: #3b82f6;
    }
    
    /* Order Again Button */
    .btn-order-again {
        background: linear-gradient(135deg, var(--accent) 0%, #c0392b 100%);
        color: white;
        padding: 0.8rem 1.8rem;
        border-radius: 0.75rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        margin-top: 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-order-again:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(217, 118, 66, 0.35);
    }
    
    .text-center {
        text-align: center;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    
    .empty-state svg {
        width: 80px;
        height: 80px;
        color: #d1d5db;
        margin-bottom: 1rem;
    }
    
    .empty-state h3 {
        font-size: 1.25rem;
        color: var(--wood);
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    
    .empty-state p {
        color: #6b7280;
        margin-bottom: 1.5rem;
    }
    
    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .pagination a, .pagination span {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        text-decoration: none;
        color: var(--wood);
        background: white;
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
        font-size: 0.85rem;
    }
    
    .pagination a:hover {
        background: var(--sage);
        color: white;
        border-color: var(--sage);
    }
    
    .pagination .active span {
        background: var(--sage);
        color: white;
        border-color: var(--sage);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .order-header-section h1 {
            font-size: 1.75rem !important;
        }
        
        .order-header-section p {
            font-size: 0.85rem !important;
        }
        
        .order-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .order-footer {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .filter-section {
            flex-direction: column;
            align-items: stretch;
        }
        
        .filter-buttons {
            justify-content: center;
        }
        
        .total-count {
            text-align: center;
        }
    }
</style>
@endpush

@section('content')
<!-- Header Section - SAMA SEPERTI HEADER CART -->
<section class="order-header-section" style="background: #8BA888 !important; background-color: #8BA888 !important;">
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
            <div class="order-card" data-status="{{ $order->status }}">
                <div class="order-header">
                    <div>
                        <span class="order-number">{{ $order->order_number }}</span>
                        <span class="order-date">{{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d F Y H:i') }}</span>
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
                    @elseif($order->status == 'cancelled')
                        <div class="status-message cancelled">
                            ❌ Pesanan telah dibatalkan
                        </div>
                    @endif
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
            fetch(`/order/${id}/cancel`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    location.reload();
                } else {
                    alert(data.message || 'Gagal membatalkan pesanan');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            });
        }
    }
    
    // Filter functionality
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const filter = this.dataset.filter;
            
            // Update active button
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Filter cards
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