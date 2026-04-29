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
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 15px rgba(139, 168, 136, 0.3);
    }
    
    .header-title h1 {
        font-family: 'Playfair Display', serif;
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--white);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    /* ==================== STATS GRID ==================== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
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
    
    /* ==================== FILTER BAR ==================== */
    .filter-bar {
        background: var(--white);
        border-radius: 1rem;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
        border: 1px solid var(--border);
        display: flex;
        gap: 1rem;
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
    
    /* ==================== TABLE CONTAINER ==================== */
    .table-container {
        background: var(--white);
        border-radius: 1rem;
        overflow-x: auto;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        border: 1px solid var(--border);
    }
    
    .reservasi-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 900px;
    }
    
    .reservasi-table th {
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
    
    .reservasi-table td {
        padding: 1rem;
        color: var(--gray);
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
    }
    
    .reservasi-table tr:hover td {
        background: var(--sage-light);
    }
    
    /* ==================== STATUS BADGE ==================== */
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
    .status-confirmed { background: #D1FAE5; color: #059669; }
    .status-cancelled { background: #FEE2E2; color: #DC2626; }
    .status-completed { background: #DBEAFE; color: #2563EB; }
    .status-archived { background: #E5E7EB; color: #6B7280; }
    
    /* ==================== ACTION BUTTONS ==================== */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .btn-confirm, .btn-cancel, .btn-delete, .btn-restore {
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
    
    .btn-confirm { background: #D1FAE5; color: #059669; }
    .btn-confirm:hover { background: #059669; color: white; transform: translateY(-2px); }
    .btn-cancel { background: #FEF3C7; color: #D97706; }
    .btn-cancel:hover { background: #D97706; color: white; transform: translateY(-2px); }
    .btn-delete { background: #FEE2E2; color: #DC2626; }
    .btn-delete:hover { background: #DC2626; color: white; transform: translateY(-2px); }
    .btn-restore { background: #E5E7EB; color: #6B7280; }
    .btn-restore:hover { background: #6B7280; color: white; transform: translateY(-2px); }
    
    /* ==================== BULK ACTIONS ==================== */
    .bulk-actions {
        background: var(--light);
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        margin-bottom: 1rem;
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        align-items: center;
    }
    
    .bulk-label {
        font-size: 0.7rem;
        font-weight: 600;
        color: var(--wood);
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    /* ==================== CHECKBOX ==================== */
    .checkbox-select {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: var(--sage);
    }
    
    /* ==================== PAGINATION ==================== */
    .pagination {
        margin-top: 1.5rem;
        padding: 1rem;
        display: flex;
        justify-content: center;
        border-top: 1px solid var(--border);
    }
    
    /* Alert */
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
    
    /* Empty State */
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
    
    /* Responsive */
    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .filter-bar { flex-direction: column; align-items: stretch; }
        .filter-group { justify-content: center; }
        .action-buttons { flex-direction: column; }
        .btn-confirm, .btn-cancel, .btn-delete, .btn-restore { width: 100%; justify-content: center; }
    }
</style>
@endpush

@section('content')
<div>
    <!-- Header Section -->
    <div class="page-header">
        <div class="header-title">
            <h1>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="28" height="28">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Kelola Reservasi
            </h1>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card" onclick="filterStatus('all')">
            <div class="stat-number">{{ $statusCount['total'] ?? 0 }}</div>
            <div class="stat-label">📊 Total</div>
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
            <input type="text" name="search" class="filter-input" placeholder="🔍 Cari nama/email/telepon" value="{{ request('search') }}">
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
            <span class="bulk-label">⚡ Aksi Massal</span>
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
                    <th width="18%">Nama</th>
                    <th width="15%">Kontak</th>
                    <th width="12%">Tanggal/Jam</th>
                    <th width="8%">Orang</th>
                    <th width="12%">Tipe/Lantai</th>
                    <th width="10%">Status</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservasis as $reservasi)
                <tr data-status="{{ $reservasi->status }}" id="row-{{ $reservasi->id }}">
                    <td><input type="checkbox" class="checkbox-select-item" value="{{ $reservasi->id }}"></td>
                    <td>#{{ $reservasi->id }}</td>
                    <td>
                        <strong style="color: var(--wood);">{{ $reservasi->name }}</strong>
                        <br><small style="color: var(--gray);">{{ $reservasi->email }}</small>
                    </td>
                    <td>{{ $reservasi->phone }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($reservasi->date)->format('d/m/Y') }}
                        <br><small>{{ $reservasi->time }} WIB</small>
                    </td>
                    <td>{{ $reservasi->people }} orang</span></td>
                    <td>
                        @if($reservasi->table_type)
                            <span style="background: var(--sage-light); color: var(--sage); padding: 0.2rem 0.5rem; border-radius: 12px; font-size: 0.65rem;">
                                {{ ucfirst($reservasi->table_type) }}
                            </span>
                            <br>
                        @endif
                        @if($reservasi->floor)
                            <small>Lantai {{ $reservasi->floor }}</small>
                        @else
                            <small>-</small>
                        @endif
                    </td>
                    <td>
                        @if($reservasi->status == 'pending')
                            <span class="status-badge status-pending">⏳ Menunggu</span>
                        @elseif($reservasi->status == 'confirmed')
                            <span class="status-badge status-confirmed">✅ Dikonfirmasi</span>
                        @elseif($reservasi->status == 'cancelled')
                            <span class="status-badge status-cancelled">❌ Dibatalkan</span>
                        @elseif($reservasi->status == 'completed')
                            <span class="status-badge status-completed">📋 Selesai</span>
                        @else
                            <span class="status-badge status-archived">📦 Diarsipkan</span>
                        @endif
                    </td>
                    <td class="action-buttons">
                        @if($reservasi->status == 'pending')
                            <button class="btn-confirm" onclick="updateStatus({{ $reservasi->id }}, 'confirmed', this)">
                                ✅ Konfirmasi
                            </button>
                            <button class="btn-cancel" onclick="updateStatus({{ $reservasi->id }}, 'cancelled', this)">
                                ❌ Batal
                            </button>
                            <button class="btn-delete" onclick="archiveReservasi({{ $reservasi->id }}, this)">
                                📦 Arsipkan
                            </button>
                        @elseif($reservasi->status == 'confirmed')
                            <button class="btn-delete" onclick="archiveReservasi({{ $reservasi->id }}, this)">
                                📦 Arsipkan
                            </button>
                        @elseif($reservasi->status == 'cancelled')
                            <button class="btn-delete" onclick="archiveReservasi({{ $reservasi->id }}, this)">
                                📦 Arsipkan
                            </button>
                        @elseif($reservasi->status == 'completed')
                            <button class="btn-delete" onclick="archiveReservasi({{ $reservasi->id }}, this)">
                                📦 Arsipkan
                            </button>
                        @elseif($reservasi->status == 'archived')
                            <button class="btn-restore" onclick="restoreReservasi({{ $reservasi->id }}, this)">
                                🔄 Pulihkan
                            </button>
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
                            <p>Belum ada reservasi</p>
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
        let statusText = '';
        if (status === 'confirmed') statusText = 'Dikonfirmasi';
        else if (status === 'cancelled') statusText = 'Dibatalkan';
        
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
    
    function archiveReservasi(id, btn) {
        if(confirm('Arsipkan reservasi ini? Reservasi akan disembunyikan dari halaman admin tetapi tetap terlihat di riwayat customer.')) {
            const originalText = btn.innerHTML;
            btn.innerHTML = '⏳...';
            btn.disabled = true;
            
            // Gunakan POST dengan _method=DELETE (method spoofing yang lebih aman)
            fetch(`/admin/reservasi/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ 
                    '_method': 'DELETE'
                })
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
                // Jika error tapi mungkin berhasil, reload saja
                location.reload();
            });
        }
    }
    
    function restoreReservasi(id, btn) {
        if(confirm('Pulihkan reservasi ini? Reservasi akan muncul kembali di halaman admin.')) {
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
    
    function bulkAction(action) {
        const selected = [];
        document.querySelectorAll('.checkbox-select-item:checked').forEach(checkbox => {
            selected.push(checkbox.value);
        });
        
        if(selected.length === 0) {
            alert('Pilih minimal satu reservasi');
            return;
        }
        
        let confirmMessage = '';
        
        if(action === 'confirm') {
            confirmMessage = `Konfirmasi ${selected.length} reservasi yang dipilih?`;
        } else if(action === 'cancel') {
            confirmMessage = `Batalkan ${selected.length} reservasi yang dipilih?`;
        } else if(action === 'archive') {
            confirmMessage = `Arsipkan ${selected.length} reservasi yang dipilih?`;
        } else if(action === 'restore') {
            confirmMessage = `Pulihkan ${selected.length} reservasi yang dipilih?`;
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