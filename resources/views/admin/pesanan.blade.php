@extends('admin.layouts.sidebar')

@section('title', 'Kelola Pesanan')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/pesanan.css') }}">
@endpush

@section('content')
<div>
    <div class="page-header">
        <h1>
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="28" height="28">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            Kelola Pesanan
        </h1>
    </div>
    
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card" onclick="filterStatus('all')">
            <div class="stat-number">{{ $statusCount['total'] ?? 0 }}</div>
            <div class="stat-label">📊 Total Pesanan</div>
        </div>
        <div class="stat-card" onclick="filterStatus('pending')">
            <div class="stat-number">{{ $statusCount['pending'] ?? 0 }}</div>
            <div class="stat-label">⏳ Menunggu</div>
        </div>
        <div class="stat-card" onclick="filterStatus('processed')">
            <div class="stat-number">{{ $statusCount['processed'] ?? 0 }}</div>
            <div class="stat-label">🔄 Diproses</div>
        </div>
        <div class="stat-card" onclick="filterStatus('completed')">
            <div class="stat-number">{{ $statusCount['completed'] ?? 0 }}</div>
            <div class="stat-label">✅ Selesai</div>
        </div>
        <div class="stat-card" onclick="filterStatus('cancelled')">
            <div class="stat-number">{{ $statusCount['cancelled'] ?? 0 }}</div>
            <div class="stat-label">❌ Dibatalkan</div>
        </div>
    </div>
    
    @if(session('success'))
    <div class="alert-success">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif
    
    @if(session('error'))
    <div class="alert-error">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif
    
    <!-- Filter Bar -->
    <div class="filter-bar">
        <form method="GET" action="{{ route('admin.pesanan') }}" class="filter-group">
            <input type="text" name="search" class="filter-input" placeholder="🔍 Cari nama / email / order" value="{{ request('search') }}">
            <select name="status" class="filter-input" id="statusFilter">
                <option value="">📋 Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Menunggu</option>
                <option value="processed" {{ request('status') == 'processed' ? 'selected' : '' }}>🔄 Diproses</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>✅ Selesai</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>❌ Dibatalkan</option>
            </select>
            <input type="date" name="date" class="filter-input" value="{{ request('date') }}">
            <button type="submit" class="filter-btn filter-btn-primary">🔍 Filter</button>
            <a href="{{ route('admin.pesanan') }}" class="filter-btn filter-btn-secondary">🔄 Reset</a>
        </form>
    </div>
    
    <!-- Table -->
    <div class="table-container">
        <table class="order-table">
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Info Order</th>
                    <th>Customer</th>
                    <th>Item Pesanan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesanans as $pesanan)
                @php
                    $createdAt = \Carbon\Carbon::parse($pesanan->created_at)->setTimezone('Asia/Jakarta');
                    $updatedAt = \Carbon\Carbon::parse($pesanan->updated_at)->setTimezone('Asia/Jakarta');
                    $items = is_string($pesanan->items) ? json_decode($pesanan->items, true) : $pesanan->items;
                @endphp
                <tr data-status="{{ $pesanan->status }}" id="order-row-{{ $pesanan->id }}">
                    <!-- ID Pesanan -->
                    <td>
                        <span class="order-number">#{{ $pesanan->id }}</span>
                    </td>
                    
                    <!-- Info Order -->
                    <td>
                        <div style="font-weight: 600; color: var(--wood); margin-bottom: 0.2rem;">{{ $pesanan->order_number }}</div>
                        <div class="time-wrapper">
                            <div class="time-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $createdAt->translatedFormat('d F Y') }}
                            </div>
                            <div class="time-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $createdAt->format('H:i') }} WIB
                            </div>
                        </div>
                     </td>
                    
                    <!-- Customer -->
                    <td>
                        <div class="customer-name">
                            <span>👤</span> {{ $pesanan->customer_name }}
                        </div>
                        <div class="customer-email">{{ $pesanan->customer_email }}</div>
                     </td>
                    
                    <!-- Items -->
                    <td>
                        <div class="items-list">
                            @if(is_array($items) && count($items) > 0)
                                @foreach($items as $item)
                                    <span class="item-badge">
                                        {{ $item['name'] ?? 'Menu' }}
                                        <span class="item-quantity">x{{ $item['quantity'] ?? 0 }}</span>
                                    </span>
                                @endforeach
                            @else
                                <span class="item-badge">-</span>
                            @endif
                        </div>
                     </td>
                    
                    <!-- Total -->
                    <td class="price-total">Rp {{ number_format($pesanan->subtotal, 0, ',', '.') }}</td>
                    
                    <!-- Status -->
                    <td>
                        <span class="status-badge status-{{ $pesanan->status }}">
                            @if($pesanan->status == 'pending') ⏳ Menunggu
                            @elseif($pesanan->status == 'processed') 🔄 Diproses
                            @elseif($pesanan->status == 'completed') ✅ Selesai
                            @elseif($pesanan->status == 'cancelled') ❌ Dibatalkan
                            @endif
                        </span>
                        @if(in_array($pesanan->status, ['completed', 'cancelled']))
                            <div class="time-item" style="margin-top: 0.4rem; justify-content: center;">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $updatedAt->format('d/m/Y H:i') }} WIB
                            </div>
                        @endif
                     </td>
                    
                    <!-- Actions -->
                    <td class="action-buttons">
                        @if($pesanan->status != 'archived')
                            <div class="status-action-group">
                                @if($pesanan->status == 'pending')
                                    <button class="btn-process" onclick="updateStatus({{ $pesanan->id }}, 'processed', this)">
                                        🔄 Proses
                                    </button>
                                    <button class="btn-cancel" onclick="updateStatus({{ $pesanan->id }}, 'cancelled', this)">
                                        ❌ Batalkan
                                    </button>
                                @elseif($pesanan->status == 'processed')
                                    <button class="btn-complete" onclick="updateStatus({{ $pesanan->id }}, 'completed', this)">
                                        ✅ Selesaikan
                                    </button>
                                    <button class="btn-cancel" onclick="updateStatus({{ $pesanan->id }}, 'cancelled', this)">
                                        ❌ Batalkan
                                    </button>
                                @endif
                            </div>
                            <div class="archive-action-group">
                                <button class="btn-delete" onclick="archiveOrder({{ $pesanan->id }}, this)">
                                    📦 Arsipkan
                                </button>
                            </div>
                        @else
                            <div class="archive-action-group">
                                <button class="btn-restore" onclick="restoreOrder({{ $pesanan->id }}, this)">
                                    🔄 Pulihkan
                                </button>
                            </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            <p>✨ Belum ada pesanan ✨</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        @if(method_exists($pesanans, 'links') && $pesanans->hasPages())
        <div class="pagination">
            <nav aria-label="Pagination">
                @php $p = $pesanans->appends(request()->query()); @endphp

                @if(!$p->onFirstPage())
                    <a href="{{ $p->previousPageUrl() }}" class="page-link">« Prev</a>
                @else
                    <span class="page-link disabled">« Prev</span>
                @endif

                <span class="page-info">Showing {{ $pesanans->firstItem() }} to {{ $pesanans->lastItem() }} of {{ $pesanans->total() }} results</span>

                @if($p->hasMorePages())
                    <a href="{{ $p->nextPageUrl() }}" class="page-link">Next »</a>
                @else
                    <span class="page-link disabled">Next »</span>
                @endif
            </nav>
        </div>
        @endif
    </div>
</div>

<script>
    function updateStatus(id, status, btn) {
        let statusText = status == 'processed' ? 'Diproses' : (status == 'completed' ? 'Selesai' : 'Dibatalkan');
        
        if(confirm(`Ubah status pesanan menjadi ${statusText}?`)) {
            const originalText = btn.innerHTML;
            btn.innerHTML = '⏳...';
            btn.disabled = true;
            
            fetch(`/admin/pesanan/${id}/status`, {
                method: 'PATCH',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ status: status })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    location.reload();
                } else {
                    alert('❌ ' + (data.message || 'Gagal mengubah status'));
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('⚠️ Terjadi kesalahan pada server');
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        }
    }
    
    function archiveOrder(id, btn) {
        if(confirm('📦 Arsipkan pesanan ini? Pesanan akan disembunyikan dari halaman admin.')) {
            const originalText = btn.innerHTML;
            btn.innerHTML = '⏳...';
            btn.disabled = true;
            
            fetch(`/admin/pesanan/${id}`, { 
                method: 'DELETE', 
                headers: { 
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                } 
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    location.reload();
                } else {
                    alert('❌ ' + (data.message || 'Gagal mengarsipkan'));
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('⚠️ Terjadi kesalahan pada server');
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        }
    }
    
    function restoreOrder(id, btn) {
        if(confirm('🔄 Pulihkan pesanan ini? Pesanan akan muncul kembali di halaman admin.')) {
            const originalText = btn.innerHTML;
            btn.innerHTML = '⏳...';
            btn.disabled = true;
            
            fetch(`/admin/pesanan/${id}/restore`, { 
                method: 'PATCH', 
                headers: { 
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                } 
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    location.reload();
                } else {
                    alert('❌ ' + (data.message || 'Gagal memulihkan'));
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('⚠️ Terjadi kesalahan pada server');
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        }
    }
    
    function filterStatus(status) {
        const select = document.getElementById('statusFilter');
        if(select) {
            select.value = status;
            document.querySelector('.filter-btn-primary').click();
        }
    }
</script>
@endsection