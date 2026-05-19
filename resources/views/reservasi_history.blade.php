@extends('layouts.app')

@section('title', 'Riwayat Reservasi - Café Kopitiam33')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/reservasi_history.css') }}">
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