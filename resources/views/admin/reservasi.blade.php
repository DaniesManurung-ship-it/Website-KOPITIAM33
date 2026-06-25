{{-- resources/views/admin/reservasi.blade.php --}}
@extends('admin.layouts.sidebar')

@section('title', 'Kelola Reservasi')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/reservasi.css') }}">
@endpush

@section('content')
<div class="admin-page">
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
                            @if($reservasi->assigned_table)
                                <span class="table-badge" style="background-color: var(--sage); color: white;">
                                    🎯 {{ $reservasi->assigned_table }}
                                </span>
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
                            @elseif($reservasi->status == 'archived') 📦 Diarsipkan
                            @endif
                        </span>
                    </td>
                    
                    <!-- Actions -->
                    <td class="action-buttons">
                        @if($reservasi->status != 'archived')
                            <div class="status-action-group">
                                @if($reservasi->status == 'pending')
                                    @if(!$reservasi->admin_message)
                                        <button class="btn-process" onclick="openMessageModal({{ $reservasi->id }}, '{{ $reservasi->floor ?? 'Semua Lantai' }}')" style="background-color: var(--sage); color: white; border-color: var(--sage); margin-bottom: 5px; width: 100%;">
                                            💬 Info Meja
                                        </button>
                                        <button class="btn-cancel" onclick="updateStatus({{ $reservasi->id }}, 'cancelled', this)" style="width: 100%;">
                                            ❌ Batalkan
                                        </button>
                                    @elseif($reservasi->admin_message && !$reservasi->customer_reply)
                                        <div style="font-size: 0.75rem; color: #d97706; text-align: center; background: #fef3c7; padding: 4px 0; border-radius: 4px; margin-bottom: 5px; font-weight: 600;">
                                            ⏳ Menunggu Customer
                                        </div>
                                        <button class="btn-cancel" onclick="updateStatus({{ $reservasi->id }}, 'cancelled', this)" style="width: 100%;">
                                            ❌ Batalkan
                                        </button>
                                    @elseif($reservasi->customer_reply)
                                        <div style="background: #fef3c7; border: 1px solid #fde68a; padding: 6px; border-radius: 4px; margin-bottom: 8px;">
                                            <span style="font-size: 0.8rem; color: #92400e; display: block; font-weight: bold;">Pilihan Meja:</span>
                                            <span style="font-size: 0.9rem; color: #b45309; display: block;">{{ $reservasi->customer_reply }}</span>
                                        </div>
                                        <button class="btn-confirm" onclick="updateStatus({{ $reservasi->id }}, 'confirmed', this)" style="width: 100%; margin-bottom: 8px;">
                                            ✅ Konfirmasi Akhir
                                        </button>
                                        <button class="btn-cancel" onclick="updateStatus({{ $reservasi->id }}, 'cancelled', this)" style="width: 100%;">
                                            ❌ Batalkan
                                        </button>
                                    @endif
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

<!-- Modal Kirim Pesan Meja -->
<div id="messageModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; padding: 24px; border-radius: 12px; width: 90%; max-width: 450px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
        <h3 style="margin-bottom: 16px; color: var(--wood); font-family: 'Playfair Display', serif; font-size: 1.5rem; border-bottom: 1px solid #e5e7eb; padding-bottom: 12px;">💬 Kirim Info Meja Tersedia</h3>
        <p style="font-size: 0.95rem; margin-bottom: 16px; color: #4b5563;">Mengirim opsi meja untuk Lantai: <span id="modalFloorName" style="font-weight: bold; color: var(--sage);"></span></p>
        <form id="messageForm">
            <input type="hidden" id="messageReservasiId">
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 0.9rem; margin-bottom: 8px; font-weight: 500; color: #374151;">Daftar Meja Kosong (Pisahkan dengan koma):</label>
                <textarea id="adminMessage" rows="3" placeholder="Contoh: Meja 1, Meja 3, Meja 5" style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; outline: none; font-family: inherit; resize: vertical;"></textarea>
            </div>
            <div style="display: flex; gap: 12px; justify-content: flex-end;">
                <button type="button" onclick="closeMessageModal()" style="padding: 8px 20px; border: 1px solid #d1d5db; background: white; border-radius: 6px; cursor: pointer; font-weight: 500; color: #4b5563; transition: all 0.2s;">Batal</button>
                <button type="button" onclick="submitMessage()" style="padding: 8px 20px; border: none; background: var(--sage); color: white; border-radius: 6px; cursor: pointer; font-weight: 500; transition: all 0.2s;">Kirim Pesan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openMessageModal(id, floor) {
        document.getElementById('messageReservasiId').value = id;
        document.getElementById('modalFloorName').innerText = floor || '-';
        document.getElementById('adminMessage').value = '';
        document.getElementById('messageModal').style.display = 'flex';
    }

    function closeMessageModal() {
        document.getElementById('messageModal').style.display = 'none';
    }

    function submitMessage() {
        const id = document.getElementById('messageReservasiId').value;
        const message = document.getElementById('adminMessage').value;
        
        if (!message.trim()) {
            alert('Pesan tidak boleh kosong!');
            return;
        }

        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '⏳...';
        btn.disabled = true;

        fetch(`/admin/reservasi/${id}/message`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ admin_message: message })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload();
            } else {
                alert('❌ ' + (data.message || 'Gagal mengirim pesan'));
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

    function updateStatus(id, status, btn) {
        let statusText = status === 'confirmed' ? 'Dikonfirmasi' : 'Dibatalkan';
        
        window.customConfirmAction(`Apakah Anda yakin ingin mengubah status reservasi menjadi ${statusText}?`, () => {
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
        });
    }
    
    // PERBAIKAN: Mengubah method dari DELETE menjadi PATCH
// PERBAIKAN: Menggunakan method DELETE (sama seperti pesanan)
function archiveReservasi(id, btn) {
    window.customConfirmAction('📦 Arsipkan reservasi ini? Reservasi akan disembunyikan dari halaman admin.', () => {
        const originalText = btn.innerHTML;
        btn.innerHTML = '⏳...';
        btn.disabled = true;
        
        fetch(`/admin/reservasi/${id}`, { 
            method: 'DELETE',  // SEKARANG PAKAI DELETE, SAMA SEPERTI PESANAN
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
    });
}

function restoreReservasi(id, btn) {
    window.customConfirmAction('🔄 Pulihkan reservasi ini? Reservasi akan muncul kembali di halaman admin.', () => {
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
    });
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
        
        if(action === 'confirm') {
            confirmMessage = `✅ Konfirmasi ${selected.length} reservasi yang dipilih?`;
        } else if(action === 'cancel') {
            confirmMessage = `❌ Batalkan ${selected.length} reservasi yang dipilih?`;
        } else if(action === 'archive') {
            confirmMessage = `📦 Arsipkan ${selected.length} reservasi yang dipilih?`;
        } else if(action === 'restore') {
            confirmMessage = `🔄 Pulihkan ${selected.length} reservasi yang dipilih?`;
        }
        
        window.customConfirmAction(confirmMessage, () => {
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
        });
    }
    
    function filterStatus(status) {
        const select = document.getElementById('statusFilter');
        if(select) {
            if(status === 'all') {
                select.value = '';
            } else {
                select.value = status;
            }
            // Cari tombol filter dan klik
            const filterBtn = document.querySelector('.filter-btn-primary');
            if(filterBtn) {
                filterBtn.click();
            }
        }
    }
    
    // Fungsi notifikasi sederhana
    function showNotification(type, message) {
        // Cek apakah sudah ada notifikasi
        let notification = document.querySelector('.alert-success, .alert-error');
        if(notification) {
            notification.remove();
        }
        
        // Buat notifikasi baru
        const div = document.createElement('div');
        div.className = type === 'success' ? 'alert-success' : 'alert-error';
        div.style.position = 'fixed';
        div.style.top = '20px';
        div.style.right = '20px';
        div.style.zIndex = '9999';
        div.style.maxWidth = '350px';
        div.innerHTML = `
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                ${type === 'success' ? 
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>' :
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'
                }
            </svg>
            ${message}
        `;
        document.body.appendChild(div);
        
        // Hapus notifikasi setelah 3 detik
        setTimeout(() => {
            if(div && div.parentNode) {
                div.style.opacity = '0';
                div.style.transition = 'opacity 0.3s';
                setTimeout(() => {
                    if(div && div.parentNode) {
                        div.remove();
                    }
                }, 300);
            }
        }, 3000);
    }
    
    // Select All functionality
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAll');
        if(selectAll) {
            selectAll.addEventListener('change', function() {
                document.querySelectorAll('.checkbox-select-item').forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });
        }
    });
</script>
@endsection