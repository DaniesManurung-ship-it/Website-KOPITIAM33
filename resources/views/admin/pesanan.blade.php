@extends('layouts.admin')

@section('title', 'Kelola Pesanan')

@push('styles')
<style>
    /* ==================== COLOR VARIABLES ==================== */
    :root {
        --sage: #8BA888;
        --sage-dark: #6B8A6B;
        --sage-light: #E8F0E6;
        --wood: #A67B5B;
        --wood-dark: #8B5E3C;
        --accent: #D97642;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --info: #3b82f6;
        --dark: #2C1810;
        --gray: #6B7280;
        --light: #F5EFE6;
        --white: #FFFFFF;
        --border: #E5E7EB;
    }
    
    .page-header {
        background: linear-gradient(135deg, var(--sage) 0%, var(--wood) 100%);
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 15px rgba(139, 168, 136, 0.3);
    }
    
    .page-header h1 {
        font-family: 'Playfair Display', serif;
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--white);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .stat-card {
        background: var(--white);
        border-radius: 1rem;
        padding: 1rem;
        text-align: center;
        border: 1px solid var(--border);
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }
    
    .stat-number {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--wood);
    }
    
    .stat-label {
        font-size: 0.7rem;
        color: var(--gray);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-top: 0.25rem;
    }
    
    .filter-bar {
        background: var(--white);
        border-radius: 1rem;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
        border: 1px solid var(--border);
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
    }
    
    .filter-group {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        align-items: center;
    }
    
    .filter-input {
        padding: 0.5rem 0.75rem;
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        font-size: 0.8rem;
        background: var(--white);
    }
    
    .filter-input:focus {
        outline: none;
        border-color: var(--sage);
    }
    
    .filter-btn {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        border: none;
        cursor: pointer;
        font-size: 0.75rem;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .filter-btn-primary {
        background: var(--sage);
        color: white;
    }
    
    .filter-btn-primary:hover {
        background: var(--wood);
    }
    
    .filter-btn-secondary {
        background: var(--light);
        color: var(--gray);
        text-decoration: none;
        display: inline-block;
    }
    
    .filter-btn-secondary:hover {
        background: var(--sage-light);
        color: var(--sage);
    }
    
    .table-container {
        background: var(--white);
        border-radius: 1rem;
        overflow-x: auto;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        border: 1px solid var(--border);
    }
    
    .order-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }
    
    .order-table th {
        padding: 1rem;
        text-align: left;
        background: var(--light);
        color: var(--wood);
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 2px solid var(--sage);
    }
    
    .order-table td {
        padding: 1rem;
        color: var(--gray);
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
    }
    
    .order-table tr:hover td {
        background: var(--sage-light);
    }
    
    .order-number {
        font-weight: 700;
        color: var(--dark);
        font-size: 0.85rem;
        margin-bottom: 0.25rem;
    }
    
    .order-date {
        font-size: 0.65rem;
        color: var(--gray);
    }
    
    .customer-name {
        font-weight: 600;
        color: var(--wood);
        font-size: 0.85rem;
        margin-bottom: 0.25rem;
    }
    
    .customer-email {
        font-size: 0.7rem;
        color: var(--gray);
    }
    
    .items-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.3rem;
        max-width: 250px;
    }
    
    .item-badge {
        display: inline-block;
        background: var(--sage-light);
        color: var(--sage-dark);
        padding: 0.2rem 0.6rem;
        border-radius: 12px;
        font-size: 0.65rem;
        font-weight: 500;
    }
    
    .price-total {
        font-weight: 700;
        color: var(--accent);
        font-size: 0.9rem;
    }
    
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.25rem 0.7rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    
    .status-pending { background: #FEF3C7; color: #D97706; }
    .status-processed { background: #DBEAFE; color: #2563EB; }
    .status-completed { background: #D1FAE5; color: #059669; }
    .status-cancelled { background: #FEE2E2; color: #DC2626; }
    .status-archived { background: #E5E7EB; color: #6B7280; }
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .btn-process, .btn-complete, .btn-cancel, .btn-delete, .btn-restore {
        padding: 0.35rem 0.7rem;
        border-radius: 0.5rem;
        border: none;
        cursor: pointer;
        font-size: 0.7rem;
        font-weight: 500;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }
    
    .btn-process { background: #DBEAFE; color: #2563EB; }
    .btn-process:hover { background: #2563EB; color: white; transform: translateY(-2px); }
    .btn-complete { background: #D1FAE5; color: #059669; }
    .btn-complete:hover { background: #059669; color: white; transform: translateY(-2px); }
    .btn-cancel { background: #FEF3C7; color: #D97706; }
    .btn-cancel:hover { background: #D97706; color: white; transform: translateY(-2px); }
    .btn-delete { background: #FEE2E2; color: #DC2626; }
    .btn-delete:hover { background: #DC2626; color: white; transform: translateY(-2px); }
    .btn-restore { background: #E5E7EB; color: #6B7280; }
    .btn-restore:hover { background: #6B7280; color: white; transform: translateY(-2px); }
    
    .alert-success {
        background: linear-gradient(135deg, #E8F5E9, #C8E6C9);
        color: #059669;
        padding: 0.75rem 1rem;
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid var(--success);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .alert-error {
        background: linear-gradient(135deg, #FEE2E2, #FECACA);
        color: #DC2626;
        padding: 0.75rem 1rem;
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid var(--danger);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem;
    }
    
    .empty-state svg {
        width: 80px;
        height: 80px;
        color: var(--gray);
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    
    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .filter-bar { flex-direction: column; align-items: stretch; }
        .filter-group { justify-content: center; }
        .action-buttons { flex-direction: column; }
        .btn-process, .btn-complete, .btn-cancel, .btn-delete, .btn-restore { width: 100%; justify-content: center; }
    }
</style>
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
    
    <div class="stats-grid">
        <div class="stat-card" onclick="filterStatus('all')">
            <div class="stat-number">{{ $pesanans->count() }}</div>
            <div class="stat-label">📊 Total</div>
        </div>
        <div class="stat-card" onclick="filterStatus('pending')">
            <div class="stat-number">{{ $pesanans->where('status', 'pending')->count() }}</div>
            <div class="stat-label">⏳ Menunggu</div>
        </div>
        <div class="stat-card" onclick="filterStatus('processed')">
            <div class="stat-number">{{ $pesanans->where('status', 'processed')->count() }}</div>
            <div class="stat-label">🔄 Diproses</div>
        </div>
        <div class="stat-card" onclick="filterStatus('completed')">
            <div class="stat-number">{{ $pesanans->where('status', 'completed')->count() }}</div>
            <div class="stat-label">✅ Selesai</div>
        </div>
        <div class="stat-card" onclick="filterStatus('cancelled')">
            <div class="stat-number">{{ $pesanans->where('status', 'cancelled')->count() }}</div>
            <div class="stat-label">❌ Dibatalkan</div>
        </div>
        <div class="stat-card" onclick="filterStatus('archived')">
            <div class="stat-number">{{ $pesanans->where('status', 'archived')->count() }}</div>
            <div class="stat-label">📦 Diarsipkan</div>
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
    
    <div class="filter-bar">
        <form method="GET" action="{{ route('admin.pesanan') }}" class="filter-group">
            <input type="text" name="search" class="filter-input" placeholder="🔍 Cari nama/email/order" value="{{ request('search') }}">
            <select name="status" class="filter-input" id="statusFilter">
                <option value="">📋 Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Menunggu</option>
                <option value="processed" {{ request('status') == 'processed' ? 'selected' : '' }}>🔄 Diproses</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>✅ Selesai</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>❌ Dibatalkan</option>
                <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>📦 Diarsipkan</option>
            </select>
            <input type="date" name="date" class="filter-input" value="{{ request('date') }}">
            <button type="submit" class="filter-btn filter-btn-primary">🔍 Filter</button>
            <a href="{{ route('admin.pesanan') }}" class="filter-btn filter-btn-secondary">🔄 Reset</a>
        </form>
    </div>
    
    <div class="table-container">
        <table class="order-table">
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="15%">No. Order</th>
                    <th width="15%">Customer</th>
                    <th width="25%">Pesanan</th>
                    <th width="10%">Total</th>
                    <th width="10%">Status</th>
                    <th width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesanans as $pesanan)
                <tr data-status="{{ $pesanan->status }}" id="order-row-{{ $pesanan->id }}">
                    <td>#{{ $pesanan->id }}</td>
                    <td>
                        <div class="order-number">{{ $pesanan->order_number }}</div>
                        <div class="order-date">{{ $pesanan->created_at->format('d/m/Y H:i') }}</div>
                    </td>
                    <td>
                        <div class="customer-name">{{ $pesanan->customer_name }}</div>
                        <div class="customer-email">{{ $pesanan->customer_email }}</div>
                    </td>
                    <td>
                        <div class="items-list">
                            @php
                                $items = is_string($pesanan->items) ? json_decode($pesanan->items, true) : $pesanan->items;
                            @endphp
                            @if(is_array($items) && count($items) > 0)
                                @foreach($items as $item)
                                    <span class="item-badge">
                                        {{ $item['name'] ?? 'Menu' }} ({{ $item['quantity'] ?? 0 }})
                                    </span>
                                @endforeach
                            @else
                                <span class="item-badge">-</span>
                            @endif
                        </div>
                    </td>
                    <td class="price-total">Rp {{ number_format($pesanan->subtotal, 0, ',', '.') }}</td>
                    <td>
                        <span class="status-badge status-{{ $pesanan->status }}">
                            @if($pesanan->status == 'pending') ⏳ Menunggu
                            @elseif($pesanan->status == 'processed') 🔄 Diproses
                            @elseif($pesanan->status == 'completed') ✅ Selesai
                            @elseif($pesanan->status == 'cancelled') ❌ Dibatalkan
                            @elseif($pesanan->status == 'archived') 📦 Diarsipkan
                            @endif
                        </span>
                    </td>
                    <td class="action-buttons">
                        @if($pesanan->status != 'archived')
                            @if($pesanan->status == 'pending')
                                <button class="btn-process" onclick="updateStatus({{ $pesanan->id }}, 'processed', this)">
                                    🔄 Proses
                                </button>
                                <button class="btn-cancel" onclick="updateStatus({{ $pesanan->id }}, 'cancelled', this)">
                                    ❌ Batal
                                </button>
                            @elseif($pesanan->status == 'processed')
                                <button class="btn-complete" onclick="updateStatus({{ $pesanan->id }}, 'completed', this)">
                                    ✅ Selesai
                                </button>
                                <button class="btn-cancel" onclick="updateStatus({{ $pesanan->id }}, 'cancelled', this)">
                                    ❌ Batal
                                </button>
                            @endif
                            <button class="btn-delete" onclick="archiveOrder({{ $pesanan->id }}, this)">
                                🗑️ Arsipkan
                            </button>
                        @else
                            <button class="btn-restore" onclick="restoreOrder({{ $pesanan->id }}, this)">
                                🔄 Pulihkan
                            </button>
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
                            <p>Belum ada pesanan</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        @if(method_exists($pesanans, 'links') && $pesanans->hasPages())
        <div style="padding: 1rem; border-top: 1px solid var(--border);">
            {{ $pesanans->appends(request()->query())->links() }}
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
                    alert('Gagal: ' + (data.message || 'Terjadi kesalahan'));
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan pada server');
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        }
    }
    
    function archiveOrder(id, btn) {
        if(confirm('Arsipkan pesanan ini? Pesanan akan disembunyikan dari halaman admin tetapi tetap terlihat di riwayat customer.')) {
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
                    alert('Gagal: ' + (data.message || 'Terjadi kesalahan'));
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan pada server');
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        }
    }
    
    function restoreOrder(id, btn) {
        if(confirm('Pulihkan pesanan ini? Pesanan akan muncul kembali di halaman admin.')) {
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
                    alert('Gagal: ' + (data.message || 'Terjadi kesalahan'));
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan pada server');
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