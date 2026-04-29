@extends('layouts.app')

@section('title', 'Riwayat Reservasi - Café Kopitiam33')

@push('styles')
<style>
    /* RESET & OVERRIDE */
    .reservasi-header {
        background: #8BA888 !important;
        background-color: #8BA888 !important;
        color: white !important;
        padding: 3rem 0 !important;
        text-align: center !important;
    }
    
    .reservasi-header h1 {
        font-family: 'Playfair Display', serif !important;
        font-size: 2.5rem !important;
        font-weight: 700 !important;
        margin-bottom: 0.5rem !important;
        color: white !important;
    }
    
    .reservasi-header p {
        font-size: 1rem !important;
        max-width: 600px !important;
        margin: 0 auto !important;
        opacity: 0.9 !important;
        color: white !important;
    }
    
    .reservasi-header::before,
    .reservasi-header::after {
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
    
    .reservasi-card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        border: 1px solid #f3f4f6;
    }
    
    .reservasi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        border-color: var(--sage);
    }
    
    .reservasi-header-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #f3f4f6;
        flex-wrap: wrap;
        gap: 0.75rem;
    }
    
    .reservasi-id {
        font-weight: 700;
        color: var(--wood);
        font-size: 0.9rem;
        background: var(--cream);
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
    }
    
    .reservasi-date {
        font-size: 0.7rem;
        color: #6b7280;
        margin-left: 0.5rem;
    }
    
    /* Status Badges */
    .status-pending, .status-confirmed, .status-cancelled, .status-completed {
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
    
    .status-confirmed {
        background: #D1FAE5;
        color: #065F46;
    }
    
    .status-cancelled {
        background: #FEE2E2;
        color: #991B1B;
    }
    
    .status-completed {
        background: #E0E7FF;
        color: #3730A3;
    }
    
    .reservasi-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }
    
    .info-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.85rem;
        color: #374151;
        padding: 0.25rem 0;
    }
    
    .info-item svg {
        width: 18px;
        height: 18px;
        color: var(--sage);
        flex-shrink: 0;
    }
    
    .info-item .info-label {
        color: #9ca3af;
        font-size: 0.7rem;
        margin-right: 0.25rem;
    }
    
    .notes-section {
        background: #FFFBEB;
        padding: 0.75rem 1rem;
        border-radius: 0.75rem;
        margin: 0.75rem 0;
        font-size: 0.8rem;
        color: #92400E;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        border-left: 3px solid #F59E0B;
    }
    
    .notes-section svg {
        width: 16px;
        height: 16px;
        color: #F59E0B;
        flex-shrink: 0;
        margin-top: 0.125rem;
    }
    
    .action-buttons {
        display: flex;
        gap: 0.75rem;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #f3f4f6;
        flex-wrap: wrap;
    }
    
    .btn-edit, .btn-delete {
        padding: 0.5rem 1.25rem;
        border-radius: 0.5rem;
        border: none;
        cursor: pointer;
        font-size: 0.8rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .btn-edit {
        background: var(--sage);
        color: white;
    }
    
    .btn-edit:hover {
        background: var(--wood);
        transform: translateY(-1px);
    }
    
    .btn-delete {
        background: #ef4444;
        color: white;
    }
    
    .btn-delete:hover {
        background: #dc2626;
        transform: translateY(-1px);
    }
    
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
    
    .btn-new-reservasi {
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
        border: none;
        cursor: pointer;
    }
    
    .btn-new-reservasi:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(217, 118, 66, 0.35);
    }
    
    .text-center {
        text-align: center;
    }
    
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
    
    @media (max-width: 768px) {
        .reservasi-header h1 {
            font-size: 1.75rem !important;
        }
        
        .reservasi-header p {
            font-size: 0.85rem !important;
        }
        
        .reservasi-info {
            grid-template-columns: 1fr;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn-edit, .btn-delete {
            justify-content: center;
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
        
        .reservasi-header-card {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endpush

@section('content')
<section class="reservasi-header">
    <div class="container">
        <h1>📅 Riwayat Reservasi</h1>
        <p>Lihat, edit, atau batalkan reservasi meja Anda</p>
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
    
    @if($reservations->count() > 0)
        <div class="filter-section">
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">Semua</button>
                <button class="filter-btn" data-filter="pending">⏳ Menunggu</button>
                <button class="filter-btn" data-filter="confirmed">✅ Dikonfirmasi</button>
                <button class="filter-btn" data-filter="completed">🎉 Selesai</button>
                <button class="filter-btn" data-filter="cancelled">❌ Dibatalkan</button>
            </div>
            <div class="total-count">
                Total: {{ $reservations->count() }} reservasi
            </div>
        </div>
        
        <div id="reservationsList">
            @foreach($reservations as $reservasi)
            @php
                // ========== PERBAIKAN JAM - REAL TIME WIB ==========
                // Menggunakan timezone Asia/Jakarta untuk waktu real
                $createdAt = \Carbon\Carbon::parse($reservasi->created_at)->setTimezone('Asia/Jakarta');
                $reservasiDate = \Carbon\Carbon::parse($reservasi->date)->setTimezone('Asia/Jakarta');
            @endphp
            <div class="reservasi-card" data-status="{{ $reservasi->status }}">
                <div class="reservasi-header-card">
                    <div>
                        <span class="reservasi-id">#{{ $reservasi->id }}</span>
                        <span class="reservasi-date">{{ $createdAt->translatedFormat('d F Y') }} • {{ $createdAt->format('H:i') }} WIB</span>
                    </div>
                    <span class="status-{{ $reservasi->status }}">
                        @if($reservasi->status == 'pending') 
                            ⏳ Menunggu Konfirmasi
                        @elseif($reservasi->status == 'confirmed') 
                            ✅ Dikonfirmasi
                        @elseif($reservasi->status == 'cancelled') 
                            ❌ Dibatalkan
                        @else 
                            🎉 Selesai
                        @endif
                    </span>
                </div>
                
                <div class="reservasi-info">
                    <div class="info-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span><span class="info-label">Nama:</span> {{ $reservasi->name }}</span>
                    </div>
                    <div class="info-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span><span class="info-label">Telepon:</span> {{ $reservasi->phone }}</span>
                    </div>
                    <div class="info-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span><span class="info-label">Tanggal:</span> {{ $reservasiDate->translatedFormat('d F Y') }} - {{ $reservasi->time }} WIB</span>
                    </div>
                    <div class="info-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span><span class="info-label">Jumlah Tamu:</span> {{ $reservasi->people }} orang</span>
                    </div>
                </div>
                
                @if($reservasi->notes)
                <div class="notes-section">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    <span><strong>Catatan:</strong> {{ $reservasi->notes }}</span>
                </div>
                @endif
                
                @if($reservasi->status == 'pending' && $reservasi->can_edit)
                    <div class="action-buttons">
                        <a href="{{ route('reservasi.edit', $reservasi->id) }}" class="btn-edit">
                            ✏️ Edit Reservasi
                        </a>
                        <button class="btn-delete" onclick="deleteReservasi({{ $reservasi->id }})">
                            🗑️ Batalkan Reservasi
                        </button>
                    </div>
                @elseif($reservasi->status == 'pending' && !$reservasi->can_edit)
                    <div class="status-message pending">
                        ⏳ Menunggu konfirmasi admin, reservasi tidak dapat diedit
                    </div>
                @elseif($reservasi->status == 'confirmed')
                    <div class="status-message confirmed">
                        ✅ Reservasi telah dikonfirmasi. Silakan datang tepat waktu!
                    </div>
                @elseif($reservasi->status == 'cancelled')
                    <div class="status-message cancelled">
                        ❌ Reservasi telah dibatalkan
                    </div>
                @elseif($reservasi->status == 'completed')
                    <div class="status-message confirmed">
                        🎉 Terima kasih telah berkunjung ke Kopitiam33!
                    </div>
                @endif
            </div>
            @endforeach
        </div>
        
        @if(method_exists($reservations, 'links'))
            <div class="pagination">
                {{ $reservations->links() }}
            </div>
        @endif
        
        <div class="text-center">
            <a href="{{ route('reservasi') }}" class="btn-new-reservasi">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Buat Reservasi Baru
            </a>
        </div>
    @else
        <div class="empty-state">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <h3>📭 Belum Ada Reservasi</h3>
            <p>Anda belum melakukan reservasi meja di Kopitiam33</p>
            <a href="{{ route('reservasi') }}" class="btn-new-reservasi">
                Buat Reservasi Sekarang
            </a>
        </div>
    @endif
</div>

<script>
    function deleteReservasi(id) {
        if(confirm('Apakah Anda yakin ingin membatalkan reservasi ini?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/reservasi/${id}`;
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }
    
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const filter = this.dataset.filter;
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const cards = document.querySelectorAll('.reservasi-card');
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