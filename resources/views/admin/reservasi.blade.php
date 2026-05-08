{{-- resources/views/admin/reservasi.blade.php --}}
@extends('admin.layouts.sidebar')

@section('title', 'Kelola Reservasi')

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
        --gold: #D4AF37;
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
    
    /* ==================== PAGE HEADER ==================== */
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
        content: '📅';
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
    
    /* ==================== STATS GRID ==================== */
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
    
    /* ==================== FILTER BAR ==================== */
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
    
    /* ==================== TABLE CONTAINER ==================== */
    .table-container {
        background: var(--white);
        border-radius: 1rem;
        overflow-x: auto;
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        border: 1px solid rgba(139, 168, 136, 0.1);
    }
    
    .reservasi-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1000px;
    }
    
    .reservasi-table th {
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
    
    .reservasi-table td {
        padding: 1.25rem;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }
    
    .reservasi-table tr {
        transition: all 0.2s ease;
    }
    
    .reservasi-table tr:hover td {
        background: var(--sage-light);
    }
    
    /* ==================== RESERVATION ID ==================== */
    .reservasi-id {
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
    
    /* ==================== CUSTOMER INFO ==================== */
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
    
    .customer-phone {
        font-size: 0.7rem;
        color: var(--sage);
        display: flex;
        align-items: center;
        gap: 0.3rem;
        margin-top: 0.2rem;
    }
    
    .customer-phone::before {
        content: '📞';
        font-size: 0.65rem;
    }
    
    /* ==================== DATE & TIME ==================== */
    .datetime-wrapper {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }
    
    .date-item, .time-item {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.7rem;
    }
    
    .date-item svg, .time-item svg {
        width: 12px;
        height: 12px;
        color: var(--sage);
    }
    
    .date-item {
        color: var(--wood);
        font-weight: 500;
    }
    
    .time-item {
        color: var(--gray);
    }
    
    /* ==================== PEOPLE & TABLE INFO ==================== */
    .people-info {
        display: flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--accent);
    }
    
    .table-info {
        margin-top: 0.3rem;
        display: flex;
        flex-wrap: wrap;
        gap: 0.3rem;
    }
    
    .table-badge {
        background: var(--sage-light);
        color: var(--sage-dark);
        padding: 0.2rem 0.6rem;
        border-radius: 20px;
        font-size: 0.6rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.2rem;
    }
    
    .floor-badge {
        background: #F3F4F6;
        color: #6B7280;
        padding: 0.2rem 0.6rem;
        border-radius: 20px;
        font-size: 0.6rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.2rem;
    }
    
    /* ==================== STATUS BADGE ==================== */
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
    .status-confirmed { background: #D1FAE5; color: #059669; }
    .status-cancelled { background: #FEE2E2; color: #DC2626; }
    .status-completed { background: #DBEAFE; color: #2563EB; }
    .status-archived { background: #F3F4F6; color: #6B7280; }
    
    /* ==================== ACTION BUTTONS ==================== */
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
    
    .btn-confirm, .btn-cancel, .btn-delete, .btn-restore {
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
    
    .btn-confirm { background: #D1FAE5; color: #059669; }
    .btn-confirm:hover { background: #059669; color: white; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(5, 150, 105, 0.3); }
    
    .btn-cancel { background: #FEF3C7; color: #D97706; }
    .btn-cancel:hover { background: #D97706; color: white; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(217, 119, 6, 0.3); }
    
    .btn-delete { background: #FEE2E2; color: #DC2626; }
    .btn-delete:hover { background: #DC2626; color: white; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(220, 38, 38, 0.3); }
    
    .btn-restore { background: #E5E7EB; color: #6B7280; }
    .btn-restore:hover { background: #6B7280; color: white; transform: translateY(-2px); }
    
    /* ==================== BULK ACTIONS ==================== */
    .bulk-actions {
        background: linear-gradient(135deg, var(--cream) 0%, #F0EBE2 100%);
        border-radius: 0.75rem;
        padding: 0.75rem 1.25rem;
        margin-bottom: 1rem;
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        align-items: center;
        border: 1px solid rgba(139, 168, 136, 0.15);
    }
    
    .bulk-label {
        font-size: 0.7rem;
        font-weight: 600;
        color: var(--wood);
        text-transform: uppercase;
        letter-spacing: 1px;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }
    
    /* ==================== CHECKBOX ==================== */
    .checkbox-select {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: var(--sage);
    }
    
    /* ==================== ALERT MESSAGES ==================== */
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
    
    /* ==================== PAGINATION ==================== */
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
    
    /* ==================== EMPTY STATE ==================== */
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
    
    /* ==================== RESPONSIVE ==================== */
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
        
        .btn-confirm, .btn-cancel, .btn-delete, .btn-restore {
            justify-content: center;
        }
        
        .bulk-actions {
            flex-direction: column;
            align-items: stretch;
        }
        
        .bulk-actions button {
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div>
    <!-- Header Section -->
    <div class="page-header">
        <h1>
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="28" height="28">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Kelola Reservasi
        </h1>
    </div>
    
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card" onclick="filterStatus('all')">
            <div class="stat-number">{{ $statusCount['total'] ?? 0 }}</div>
            <div class="stat-label">📊 Total Reservasi</div>
        </div>
        <div class="stat-card" onclick="filterStatus('pending')">
            <div class="stat-number">{{ $statusCount['pending'] ?? 0 }}</div>
            <div class="stat-label">⏳ Menunggu</div>
        </div>
        <div class="stat-card" onclick="filterStatus('confirmed')">
            <div class="stat-number">{{ $statusCount['confirmed'] ?? 0 }}</div>
            <div class="stat-label">✅ Dikonfirmasi</div>
        </div>
        <div class="stat-card" onclick="filterStatus('cancelled')">
            <div class="stat-number">{{ $statusCount['cancelled'] ?? 0 }}</div>
            <div class="stat-label">❌ Dibatalkan</div>
        </div>
        <div class="stat-card" onclick="filterStatus('completed')">
            <div class="stat-number">{{ $statusCount['completed'] ?? 0 }}</div>
            <div class="stat-label">📋 Selesai</div>
        </div>
        <div class="stat-card" onclick="filterStatus('archived')">
            <div class="stat-number">{{ $statusCount['archived'] ?? 0 }}</div>
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
        <form method="GET" action="{{ route('admin.reservasi') }}" class="filter-group">
            <input type="text" name="search" class="filter-input" placeholder="🔍 Cari nama / email / telepon" value="{{ request('search') }}">
            <select name="status" class="filter-input" id="statusFilter">
                <option value="">📋 Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Menunggu</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>✅ Dikonfirmasi</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>❌ Dibatalkan</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>📋 Selesai</option>
                <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>📦 Diarsipkan</option>
            </select>
            <input type="date" name="date" class="filter-input" value="{{ request('date') }}">
            <button type="submit" class="filter-btn filter-btn-primary">🔍 Filter</button>
            <a href="{{ route('admin.reservasi') }}" class="filter-btn filter-btn-secondary">🔄 Reset</a>
        </form>
    </div>
    
    <!-- Table Section -->
    <div class="table-container">
        <!-- Bulk Actions -->
        <div class="bulk-actions">
            <span class="bulk-label">
                <span>⚡</span> Aksi Massal
            </span>
            <button class="btn-confirm" onclick="bulkAction('confirm')">✅ Konfirmasi Terpilih</button>
            <button class="btn-cancel" onclick="bulkAction('cancel')">❌ Batalkan Terpilih</button>
            <button class="btn-delete" onclick="bulkAction('archive')">📦 Arsipkan Terpilih</button>
            <button class="btn-restore" onclick="bulkAction('restore')">🔄 Pulihkan Terpilih</button>
        </div>
        
        <table class="reservasi-table">
            <thead>
                <tr>
                    <th width="5%"><input type="checkbox" id="selectAll" class="checkbox-select"></th>
                    <th width="5%">ID</th>
                    <th width="18%">Customer</th>
                    <th width="15%">Kontak</th>
                    <th width="15%">Tanggal & Waktu</th>
                    <th width="8%">Orang</th>
                    <th width="12%">Detail Meja</th>
                    <th width="10%">Status</th>
                    <th width="12%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservasis as $reservasi)
                @php
                    $createdAt = \Carbon\Carbon::parse($reservasi->created_at)->setTimezone('Asia/Jakarta');
                    $reservasiDate = \Carbon\Carbon::parse($reservasi->date);
                @endphp
                <tr data-status="{{ $reservasi->status }}" id="row-{{ $reservasi->id }}">
                    <!-- Checkbox -->
                    <td><input type="checkbox" class="checkbox-select-item" value="{{ $reservasi->id }}"></td>
                    
                    <!-- ID -->
                    <td><span class="reservasi-id">#{{ $reservasi->id }}</span></td>
                    
                    <!-- Customer Info -->
                    <td>
                        <div class="customer-name">
                            <span>👤</span> {{ $reservasi->name }}
                        </div>
                        <div class="customer-email">{{ $reservasi->email }}</div>
                    </td>
                    
                    <!-- Contact -->
                    <td>
                        <div class="customer-phone">{{ $reservasi->phone }}</div>
                    </td>
                    
                    <!-- Date & Time -->
                    <td>
                        <div class="datetime-wrapper">
                            <div class="date-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $reservasiDate->translatedFormat('d F Y') }}
                            </div>
                            <div class="time-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $reservasi->time }} WIB
                            </div>
                        </div>
                     </td>
                    
                    <!-- People -->
                    <td>
                        <div class="people-info">
                            <span>👥</span> {{ $reservasi->people }} orang
                        </div>
                    </td>
                    
                    <!-- Table Details -->
                    <td>
                        <div class="table-info">
                            @if($reservasi->table_type)
                                <span class="table-badge">
                                    🪑 {{ ucfirst($reservasi->table_type) }}
                                </span>
                            @endif
                            @if($reservasi->floor)
                                <span class="floor-badge">
                                    🏢 Lantai {{ $reservasi->floor }}
                                </span>
                            @else
                                <span class="floor-badge">-</span>
                            @endif
                        </div>
                        @if($reservasi->notes)
                            <small style="display: block; margin-top: 0.3rem; color: var(--gray); font-size: 0.6rem;">
                                📝 {{ Str::limit($reservasi->notes, 30) }}
                            </small>
                        @endif
                    </td>
                    
                    <!-- Status -->
                    <td>
                        <span class="status-badge status-{{ $reservasi->status }}">
                            @if($reservasi->status == 'pending') ⏳ Menunggu
                            @elseif($reservasi->status == 'confirmed') ✅ Dikonfirmasi
                            @elseif($reservasi->status == 'cancelled') ❌ Dibatalkan
                            @elseif($reservasi->status == 'completed') 📋 Selesai
                            @else 📦 Diarsipkan
                            @endif
                        </span>
                    </td>
                    
                    <!-- Actions -->
                    <td class="action-buttons">
                        @if($reservasi->status != 'archived')
                            <div class="status-action-group">
                                @if($reservasi->status == 'pending')
                                    <button class="btn-confirm" onclick="updateStatus({{ $reservasi->id }}, 'confirmed', this)">
                                        ✅ Konfirmasi
                                    </button>
                                    <button class="btn-cancel" onclick="updateStatus({{ $reservasi->id }}, 'cancelled', this)">
                                        ❌ Batalkan
                                    </button>
                                @endif
                            </div>
                            <div class="archive-action-group">
                                <button class="btn-delete" onclick="archiveReservasi({{ $reservasi->id }}, this)">
                                    📦 Arsipkan
                                </button>
                            </div>
                        @else
                            <div class="archive-action-group">
                                <button class="btn-restore" onclick="restoreReservasi({{ $reservasi->id }}, this)">
                                    🔄 Pulihkan
                                </button>
                            </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">
                        <div class="empty-state">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p>✨ Belum ada reservasi ✨</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <!-- Pagination -->
        @if($reservasis->hasPages())
        <div class="pagination">
            {{ $reservasis->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

<script>
    function updateStatus(id, status, btn) {
        let statusText = status === 'confirmed' ? 'Dikonfirmasi' : 'Dibatalkan';
        
        if (confirm(`Apakah Anda yakin ingin mengubah status reservasi menjadi ${statusText}?`)) {
            const originalText = btn.innerHTML;
            btn.innerHTML = '⏳...';
            btn.disabled = true;
            
            fetch(`/admin/reservasi/${id}/status`, {
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
    
    function archiveReservasi(id, btn) {
        if(confirm('📦 Arsipkan reservasi ini? Reservasi akan disembunyikan dari halaman admin.')) {
            const originalText = btn.innerHTML;
            btn.innerHTML = '⏳...';
            btn.disabled = true;
            
            fetch(`/admin/reservasi/${id}`, {
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
    
    function restoreReservasi(id, btn) {
        if(confirm('🔄 Pulihkan reservasi ini? Reservasi akan muncul kembali di halaman admin.')) {
            const originalText = btn.innerHTML;
            btn.innerHTML = '⏳...';
            btn.disabled = true;
            
            fetch(`/admin/reservasi/${id}/restore`, {
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
    
    function bulkAction(action) {
        const selected = [];
        document.querySelectorAll('.checkbox-select-item:checked').forEach(checkbox => {
            selected.push(checkbox.value);
        });
        
        if(selected.length === 0) {
            alert('⚠️ Pilih minimal satu reservasi');
            return;
        }
        
        let confirmMessage = '';
        let actionText = '';
        
        if(action === 'confirm') {
            confirmMessage = `✅ Konfirmasi ${selected.length} reservasi yang dipilih?`;
            actionText = 'dikonfirmasi';
        } else if(action === 'cancel') {
            confirmMessage = `❌ Batalkan ${selected.length} reservasi yang dipilih?`;
            actionText = 'dibatalkan';
        } else if(action === 'archive') {
            confirmMessage = `📦 Arsipkan ${selected.length} reservasi yang dipilih?`;
            actionText = 'diarsipkan';
        } else if(action === 'restore') {
            confirmMessage = `🔄 Pulihkan ${selected.length} reservasi yang dipilih?`;
            actionText = 'dipulihkan';
        }
        
        if(confirm(confirmMessage)) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.reservasi.bulk") }}';
            form.innerHTML = `
                @csrf
                <input type="hidden" name="ids" value="${selected.join(',')}">
                <input type="hidden" name="action" value="${action}">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }
    
    function filterStatus(status) {
        const select = document.getElementById('statusFilter');
        if(select) {
            if(status === 'all') {
                select.value = '';
            } else {
                select.value = status;
            }
            document.querySelector('.filter-btn-primary').click();
        }
    }
    
    // Select All
    const selectAll = document.getElementById('selectAll');
    if(selectAll) {
        selectAll.addEventListener('change', function() {
            document.querySelectorAll('.checkbox-select-item').forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }
</script>
@endsection