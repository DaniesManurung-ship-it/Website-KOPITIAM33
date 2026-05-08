@extends('admin.layouts.sidebar')

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
        --accent-light: #FFE4D6;
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
    
    /* Page Header */
    .page-header {
        background: linear-gradient(135deg, var(--sage) 0%, var(--wood) 100%);
        border-radius: 1.5rem;
        padding: 1.5rem 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 8px 20px rgba(139, 168, 136, 0.25);
        position: relative;
        overflow: hidden;
    }
    
    .page-header::before {
        content: '📦';
        position: absolute;
        bottom: -20px;
        right: -20px;
        font-size: 100px;
        opacity: 0.08;
        transform: rotate(-15deg);
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
        position: relative;
        z-index: 1;
    }
    
    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .stat-card {
        background: var(--white);
        border-radius: 1rem;
        padding: 1rem 1.25rem;
        text-align: center;
        border: 1px solid rgba(139, 168, 136, 0.15);
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, var(--sage), var(--accent));
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }
    
    .stat-card:hover::after {
        transform: scaleX(1);
    }
    
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.1);
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
        font-size: 0.7rem;
        color: var(--gray);
        font-weight: 500;
        letter-spacing: 0.5px;
        margin-top: 0.25rem;
    }
    
    /* Filter Bar */
    .filter-bar {
        background: var(--white);
        border-radius: 1rem;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid rgba(139, 168, 136, 0.15);
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
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
        transition: all 0.2s;
    }
    
    .filter-input:focus {
        outline: none;
        border-color: var(--sage);
        box-shadow: 0 0 0 3px rgba(139, 168, 136, 0.1);
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
        background: linear-gradient(135deg, var(--sage) 0%, var(--wood) 100%);
        color: white;
    }
    
    .filter-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(139, 168, 136, 0.3);
    }
    
    .filter-btn-secondary {
        background: #f3f4f6;
        color: var(--gray);
        text-decoration: none;
        display: inline-block;
    }
    
    .filter-btn-secondary:hover {
        background: var(--sage-light);
        color: var(--sage);
    }
    
    /* Table Container */
    .table-container {
        background: var(--white);
        border-radius: 1rem;
        overflow-x: auto;
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        border: 1px solid rgba(139, 168, 136, 0.1);
    }
    
    .order-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1000px;
    }
    
    .order-table th {
        padding: 1rem 1.25rem;
        text-align: left;
        background: linear-gradient(135deg, var(--cream) 0%, #F0EBE2 100%);
        color: var(--wood);
        font-weight: 600;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 2px solid var(--sage);
    }
    
    .order-table td {
        padding: 1.25rem;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }
    
    .order-table tr {
        transition: all 0.2s ease;
    }
    
    .order-table tr:hover td {
        background: var(--sage-light);
    }
    
    /* Order ID */
    .order-number {
        font-family: 'SF Mono', 'Courier New', monospace;
        font-size: 0.7rem;
        font-weight: 600;
        color: var(--wood);
        background: var(--cream);
        padding: 0.25rem 0.6rem;
        border-radius: 20px;
        display: inline-block;
        letter-spacing: 0.5px;
    }
    
    /* Time Info - Clean & Modern */
    .time-wrapper {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
        margin-top: 0.5rem;
        padding-top: 0.5rem;
        border-top: 1px dashed rgba(139, 168, 136, 0.2);
    }
    
    .time-item {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.65rem;
        color: var(--gray);
    }
    
    .time-item svg {
        width: 12px;
        height: 12px;
        color: var(--sage);
    }
    
    /* Customer Info */
    .customer-name {
        font-weight: 600;
        color: var(--wood);
        font-size: 0.85rem;
        margin-bottom: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }
    
    .customer-email {
        font-size: 0.7rem;
        color: var(--gray);
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }
    
    .customer-email::before {
        content: '✉️';
        font-size: 0.65rem;
    }
    
    /* Items List - Badge Style */
    .items-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.4rem;
        max-width: 280px;
    }
    
    .item-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        background: linear-gradient(135deg, var(--sage-light) 0%, #F5F0EA 100%);
        color: var(--wood-dark);
        padding: 0.2rem 0.7rem;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .item-badge:hover {
        background: var(--sage);
        color: white;
        transform: translateY(-1px);
    }
    
    .item-quantity {
        background: var(--accent);
        color: white;
        border-radius: 12px;
        padding: 0.1rem 0.4rem;
        font-size: 0.55rem;
        margin-left: 0.2rem;
    }
    
    /* Price Total */
    .price-total {
        font-weight: 700;
        color: var(--accent);
        font-size: 1rem;
        font-family: 'SF Mono', monospace;
    }
    
    /* Status Badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.3rem 1rem;
        border-radius: 30px;
        font-size: 0.7rem;
        font-weight: 600;
        white-space: nowrap;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    
    .status-pending { background: #FEF3C7; color: #D97706; }
    .status-processed { background: #DBEAFE; color: #2563EB; }
    .status-completed { background: #D1FAE5; color: #059669; }
    .status-cancelled { background: #FEE2E2; color: #DC2626; }
    .status-archived { background: #F3F4F6; color: #6B7280; }
    
    /* Action Buttons */
    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .status-action-group {
        display: flex;
        gap: 0.4rem;
        flex-wrap: wrap;
    }
    
    .archive-action-group {
        display: flex;
        gap: 0.4rem;
        margin-top: 0.25rem;
        padding-top: 0.5rem;
        border-top: 1px solid rgba(139, 168, 136, 0.2);
    }
    
    .btn-process, .btn-complete, .btn-cancel, .btn-delete, .btn-restore {
        padding: 0.35rem 0.8rem;
        border-radius: 0.5rem;
        border: none;
        cursor: pointer;
        font-size: 0.7rem;
        font-weight: 500;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        white-space: nowrap;
    }
    
    .btn-process { background: #DBEAFE; color: #2563EB; }
    .btn-process:hover { background: #2563EB; color: white; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(37, 99, 235, 0.3); }
    
    .btn-complete { background: #D1FAE5; color: #059669; }
    .btn-complete:hover { background: #059669; color: white; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(5, 150, 105, 0.3); }
    
    .btn-cancel { background: #FEF3C7; color: #D97706; }
    .btn-cancel:hover { background: #D97706; color: white; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(217, 119, 6, 0.3); }
    
    .btn-delete { background: #FEE2E2; color: #DC2626; }
    .btn-delete:hover { background: #DC2626; color: white; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(220, 38, 38, 0.3); }
    
    .btn-restore { background: #E5E7EB; color: #6B7280; }
    .btn-restore:hover { background: #6B7280; color: white; transform: translateY(-2px); }
    
    /* Alert Messages */
    .alert-success, .alert-error {
        padding: 0.75rem 1rem;
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.8rem;
    }
    
    .alert-success {
        background: linear-gradient(135deg, #D1FAE5 0%, #A7F3D0 100%);
        color: #059669;
        border-left: 4px solid #10b981;
    }
    
    .alert-error {
        background: linear-gradient(135deg, #FEE2E2 0%, #FECACA 100%);
        color: #DC2626;
        border-left: 4px solid #ef4444;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem;
    }
    
    .empty-state svg {
        width: 80px;
        height: 80px;
        color: #d1d5db;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    
    .empty-state p {
        color: var(--gray);
        font-size: 0.85rem;
    }
    
    /* Pagination */
    .pagination {
        padding: 1rem;
        border-top: 1px solid var(--border);
    }
    
    .pagination nav {
        display: flex;
        justify-content: center;
    }
    
    .pagination .page-link {
        padding: 0.5rem 0.75rem;
        margin: 0 0.25rem;
        border-radius: 0.5rem;
        background: white;
        border: 1px solid var(--border);
        color: var(--wood);
        text-decoration: none;
        transition: all 0.2s;
        font-size: 0.75rem;
    }
    
    .pagination .page-link:hover {
        background: var(--sage);
        color: white;
        border-color: var(--sage);
    }
    
    .pagination .active .page-link {
        background: var(--sage);
        color: white;
        border-color: var(--sage);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }
        
        .stat-number {
            font-size: 1.5rem;
        }
        
        .filter-bar {
            flex-direction: column;
            align-items: stretch;
        }
        
        .filter-group {
            justify-content: center;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .status-action-group {
            flex-direction: column;
        }
        
        .archive-action-group {
            flex-direction: column;
        }
        
        .btn-process, .btn-complete, .btn-cancel, .btn-delete, .btn-restore {
            justify-content: center;
        }
        
        .items-list {
            max-width: 200px;
        }
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
    
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card" onclick="filterStatus('all')">
            <div class="stat-number">{{ $pesanans->total() ?? $pesanans->count() }}</div>
            <div class="stat-label">📊 Total Pesanan</div>
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
                <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>📦 Diarsipkan</option>
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
                            @elseif($pesanan->status == 'archived') 📦 Diarsipkan
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