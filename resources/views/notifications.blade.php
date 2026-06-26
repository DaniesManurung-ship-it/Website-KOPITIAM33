@extends('layouts.app')

@section('title', 'Notifikasi - Café Kopitiam33')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
@endpush

@section('content')
<!-- Header Section -->
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
        <!-- Filter Section -->
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
                
                // Memproses message untuk menambahkan warna pada status
                $message = $notif->message;
                
                // Cek dan beri warna pada "sedang diproses"
                if(strpos($message, 'sedang diproses') !== false) {
                    $message = str_replace('sedang diproses', '<span class="status-highlight proses">sedang diproses</span>', $message);
                }
                // Cek dan beri warna pada "telah selesai"
                elseif(strpos($message, 'telah selesai') !== false) {
                    $message = str_replace('telah selesai', '<span class="status-highlight selesai">telah selesai</span>', $message);
                }
                // Cek dan beri warna pada "selesai. Terima kasih telah berbelanja!"
                elseif(strpos($message, 'selesai. Terima kasih telah berbelanja!') !== false) {
                    $message = str_replace('selesai. Terima kasih telah berbelanja!', '<span class="status-highlight selesai">selesai. Terima kasih telah berbelanja!</span>', $message);
                }
                // Cek dan beri warna pada "dibatalkan"
                elseif(strpos($message, 'dibatalkan') !== false) {
                    $message = str_replace('dibatalkan', '<span class="status-highlight dibatalkan">dibatalkan</span>', $message);
                }
                // Cek dan beri warna pada "dikonfirmasi"
                elseif(strpos($message, 'dikonfirmasi') !== false) {
                    $message = str_replace('dikonfirmasi', '<span class="status-highlight dikonfirmasi">dikonfirmasi</span>', $message);
                }
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
                    <p class="notif-message">{!! $message !!}</p>

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
        
        <!-- Pagination -->
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
            <a href="{{ route('dashboard') }}" class="btn-back-home">
                🏠 Kembali ke Beranda
            </a>
        </div>
    @endif
</div>

<script>
function markAsRead(btn, id) {
    window.customConfirmAction('Tandai notifikasi ini sebagai sudah dibaca?', () => {
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
    });
}

function deleteNotification(btn, id) {
    window.customConfirmAction('Apakah Anda yakin ingin menghapus notifikasi ini?', () => {
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
    });
}

// Filter functionality
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