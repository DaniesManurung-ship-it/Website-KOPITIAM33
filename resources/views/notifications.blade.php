@extends('layouts.app')

@section('title', 'Notifikasi - Café Kopitiam33')

@push('styles')
<style>
    /* RESET & OVERRIDE - SAME AS ORDER HISTORY */
    .notif-header-section {
        background: #8BA888 !important;
        background-color: #8BA888 !important;
        color: white !important;
        padding: 3rem 0 !important;
        text-align: center !important;
    }
    
    .notif-header-section h1 {
        font-family: 'Playfair Display', serif !important;
        font-size: 2.5rem !important;
        font-weight: 700 !important;
        margin-bottom: 0.5rem !important;
        color: white !important;
    }
    
    .notif-header-section p {
        font-size: 1rem !important;
        max-width: 600px !important;
        margin: 0 auto !important;
        opacity: 0.9 !important;
        color: white !important;
    }
    
    .notif-header-section::before,
    .notif-header-section::after {
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
    
    .notif-container {
        max-width: 1280px;
        margin: 3rem auto;
        padding: 0 1rem;
    }
    
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
    
    /* Stats Cards - Same style as order history stats */
    .stats-wrapper {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }
    
    .stat-card {
        background: white;
        border-radius: 1rem;
        padding: 1rem 1.5rem;
        flex: 1;
        min-width: 130px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        border: 1px solid #f3f4f6;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        border-color: var(--sage);
    }
    
    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: var(--wood);
        font-family: 'Playfair Display', serif;
        line-height: 1.2;
    }
    
    .stat-label {
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 0.25rem;
        letter-spacing: 0.3px;
    }
    
    /* Filter Section - Same as order history */
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
    
    /* Notification Cards - Same style as order cards */
    .notif-card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        transition: all 0.3s ease;
        border: 1px solid #f3f4f6;
        position: relative;
    }
    
    .notif-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        border-color: var(--sage);
    }
    
    .notif-card.unread {
        background: linear-gradient(135deg, #FFF9F5 0%, #FFFFFF 100%);
        border-left: 4px solid var(--accent);
    }
    
    /* Notification Header - Like order header */
    .notif-header-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #f3f4f6;
        flex-wrap: wrap;
        gap: 0.75rem;
    }
    
    .notif-type {
        font-weight: 700;
        color: var(--wood);
        font-size: 0.9rem;
        background: var(--cream);
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .notif-type.order {
        background: #DBEAFE;
        color: #1E40AF;
    }
    
    .notif-type.reservation {
        background: #D1FAE5;
        color: #065F46;
    }
    
    .badge-new {
        background: var(--accent);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 2rem;
        font-size: 0.65rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    /* Time detail - Same as order history */
    .time-detail {
        display: flex;
        gap: 1rem;
        margin-top: 0.5rem;
        flex-wrap: wrap;
    }
    
    .time-item {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.7rem;
        color: #6b7280;
        background: #f9fafb;
        padding: 0.25rem 0.6rem;
        border-radius: 1rem;
    }
    
    .time-item svg {
        width: 12px;
        height: 12px;
    }
    
    /* Notification Content */
    .notif-content {
        margin-bottom: 1rem;
    }
    
    .notif-title {
        font-size: 1rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
    }
    
    .notif-message {
        font-size: 0.875rem;
        color: #6b7280;
        line-height: 1.5;
    }

    .notif-menu-images {
        margin-top: 1rem;
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .notif-menu-item {
        width: 70px;
        text-align: center;
    }

    .notif-menu-thumb {
        width: 70px;
        height: 70px;
        border-radius: 0.6rem;
        object-fit: cover;
        border: 1px solid #e5e7eb;
        background: #f3f4f6;
    }

    .notif-menu-name {
        margin-top: 0.35rem;
        font-size: 0.65rem;
        color: #6b7280;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    /* Footer Actions - Like order footer */
    .notif-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #f3f4f6;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .action-buttons-group {
        display: flex;
        gap: 0.75rem;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .btn-read {
        background: var(--sage);
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
    
    .btn-read:hover {
        background: var(--wood);
        transform: translateY(-1px);
    }
    
    .btn-delete {
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
    
    .btn-delete:hover {
        background: #dc2626;
        transform: translateY(-1px);
    }
    
    .status-read {
        font-size: 0.8rem;
        padding: 0.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #10b981;
    }
    
    /* Empty State - Same as order history */
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
    
    .btn-back-home {
        background: linear-gradient(135deg, var(--accent) 0%, #c0392b 100%);
        color: white;
        padding: 0.8rem 1.8rem;
        border-radius: 0.75rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-back-home:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(217, 118, 66, 0.35);
    }
    
    /* Pagination - Same as order history */
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
    
    /* Responsive Mobile - Same as order history */
    @media (max-width: 768px) {
        .notif-header-section h1 {
            font-size: 1.75rem !important;
        }
        
        .notif-header-section p {
            font-size: 0.85rem !important;
        }
        
        .notif-header-card {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .notif-footer {
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
        
        .action-buttons-group {
            width: 100%;
            justify-content: flex-start;
        }
        
        .time-detail {
            flex-direction: column;
            gap: 0.4rem;
        }
        
        .stats-wrapper {
            gap: 0.75rem;
        }
        
        .stat-card {
            padding: 0.75rem 1rem;
            min-width: calc(33% - 0.5rem);
        }
        
        .stat-number {
            font-size: 1.5rem;
        }
        
        .stat-label {
            font-size: 0.65rem;
        }
    }
    
    @media (max-width: 480px) {
        .stat-card {
            min-width: calc(50% - 0.375rem);
        }
        
        .notif-card {
            padding: 1rem;
        }
        
        .btn-read, .btn-delete {
            padding: 0.4rem 1rem;
            font-size: 0.75rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Header Section - Same as order history -->
<section class="notif-header-section">
    <div class="container">
        <h1>🔔 Notifikasi</h1>
        <p>Pemberitahuan tentang pesanan dan reservasi Anda</p>
    </div>
</section>

<div class="notif-container">
    @if(session('success'))
    <div class="alert-success">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif
    
    @if($notifications->count() > 0)
        <!-- Filter Section - Same as order history -->
        <div class="filter-section">
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">Semua</button>
                <button class="filter-btn" data-filter="unread">🆕 Belum Dibaca</button>
                <button class="filter-btn" data-filter="order">📦 Pesanan</button>
                <button class="filter-btn" data-filter="reservation">📅 Reservasi</button>
            </div>
            <div class="total-count">
                Total: {{ $notifications->total() }} notifikasi
            </div>
        </div>
        
        <div id="notifList">
            @foreach($notifications as $notif)
            @php
                $createdAt = \Carbon\Carbon::parse($notif->created_at);
                $createdAt->setTimezone('Asia/Jakarta');
            @endphp
            <div class="notif-card {{ !$notif->is_read ? 'unread' : '' }}" 
                 data-type="{{ $notif->type }}"
                 data-read="{{ $notif->is_read ? 'read' : 'unread' }}"
                 data-id="{{ $notif->id }}">
                
                <div class="notif-header-card">
                    <div>
                        <span class="notif-type {{ $notif->type }}">
                            @if($notif->type == 'order') 
                                📦 Pesanan
                            @else 
                                📅 Reservasi
                            @endif
                        </span>
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
                    @if(!$notif->is_read)
                        <span class="badge-new">
                            🔴 Baru
                        </span>
                    @endif
                </div>
                
                <div class="notif-content">
                    <div class="notif-title">{{ $notif->title }}</div>
                    <p class="notif-message">{{ $notif->message }}</p>

                    @if($notif->type === 'order' && !empty($notif->ordered_items))
                        <div class="notif-menu-images">
                            @foreach($notif->ordered_items as $item)
                                <div class="notif-menu-item">
                                    <img
                                        src="{{ asset($item['image']) }}"
                                        alt="{{ $item['name'] }}"
                                        class="notif-menu-thumb"
                                        onerror="this.src='{{ asset('uploads/default/default-menu.jpg') }}'"
                                    >
                                    <div class="notif-menu-name" title="{{ $item['name'] }}">
                                        {{ $item['name'] }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                <div class="notif-footer">
                    <div class="action-buttons-group">
                        @if(!$notif->is_read)
                            <button class="btn-read" onclick="markAsRead(this, {{ $notif->id }})">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Tandai Dibaca
                            </button>
                        @else
                            <div class="status-read">
                                ✓ Sudah dibaca
                            </div>
                        @endif
                        <button class="btn-delete" onclick="deleteNotification(this, {{ $notif->id }})">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination - Same as order history -->
        @if(method_exists($notifications, 'links'))
            <div class="pagination">
                {{ $notifications->links() }}
            </div>
        @endif
    @else
        <div class="empty-state">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <h3>🔕 Belum Ada Notifikasi</h3>
            <p>Notifikasi akan muncul saat pesanan atau reservasi Anda diupdate oleh admin</p>
            <a href="{{ route('home') }}" class="btn-back-home">
                🏠 Kembali ke Beranda
            </a>
        </div>
    @endif
</div>

<script>
function markAsRead(btn, id) {
    if(confirm('Tandai notifikasi ini sebagai sudah dibaca?')) {
        const originalText = btn.innerHTML;
        
        btn.disabled = true;
        btn.innerHTML = '⏳ Memproses...';
        
        fetch(`/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload();
            } else {
                alert('❌ Gagal menandai notifikasi');
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('⚠️ Terjadi kesalahan. Silakan coba lagi.');
            btn.disabled = false;
            btn.innerHTML = originalText;
        });
    }
}

function deleteNotification(btn, id) {
    if(confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')) {
        const originalText = btn.innerHTML;
        
        btn.disabled = true;
        btn.innerHTML = '⏳ Menghapus...';
        
        fetch(`/notifications/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                const card = document.querySelector(`.notif-card[data-id="${id}"]`);
                if(card) {
                    card.style.animation = 'fadeOut 0.3s ease';
                    setTimeout(() => {
                        card.remove();
                        if(document.querySelectorAll('.notif-card').length === 0) {
                            location.reload();
                        }
                    }, 300);
                }
            } else {
                alert('❌ Gagal menghapus notifikasi');
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('⚠️ Terjadi kesalahan. Silakan coba lagi.');
            btn.disabled = false;
            btn.innerHTML = originalText;
        });
    }
}

// Filter functionality - Same as order history
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const filter = this.dataset.filter;
        
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        const cards = document.querySelectorAll('.notif-card');
        cards.forEach(card => {
            if (filter === 'all') {
                card.style.display = 'block';
            } else if (filter === 'unread') {
                card.style.display = card.dataset.read === 'unread' ? 'block' : 'none';
            } else if (filter === 'order') {
                card.style.display = card.dataset.type === 'order' ? 'block' : 'none';
            } else if (filter === 'reservation') {
                card.style.display = card.dataset.type === 'reservation' ? 'block' : 'none';
            }
        });
    });
});

// Animation keyframes
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(100%);
        }
    }
`;
document.head.appendChild(style);
</script>
@endsection