@extends('admin.layouts.sidebar')

@section('title', 'Kelola Testimoni')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/testimonials.css') }}">
@endpush

@section('content')
<div class="admin-page">
    <!-- Header Section - SAMA DENGAN MENU -->
    <div class="page-header">
        <div class="header-title">
            <h1>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                Kelola Testimoni
            </h1>
        </div>
        <div class="header-stats">
            <div class="stat-card">
                <div class="stat-number">{{ $testimonials->count() }}</div>
                <div class="stat-label">Total Testimoni</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $activeCount ?? 0 }}</div>
                <div class="stat-label">Aktif</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $archivedCount ?? 0 }}</div>
                <div class="stat-label">Diarsipkan</div>
            </div>
        </div>
    </div>
    
    @if(session('success'))
    <div class="alert-success">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif
    
    <!-- Filter Section -->
    <div class="filter-section">
        <span class="filter-label">📋 Filter Status:</span>
        <button class="filter-btn active" onclick="filterTestimonials('all')">Semua</button>
        <button class="filter-btn" onclick="filterTestimonials('active')">✅ Aktif</button>
        <button class="filter-btn" onclick="filterTestimonials('archived')">📦 Diarsipkan</button>
    </div>
    
    <!-- Table Section -->
    <div class="table-container">
        <table class="testimonial-table" id="testimonialTable">
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="15%">Customer</th>
                    <th width="10%">Rating</th>
                    <th width="40%">Testimoni</th>
                    <th width="10%">Status</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody id="testimonialTableBody">
                @forelse($testimonials as $testimonial)
                <tr data-status="{{ $testimonial->is_archived ? 'archived' : 'active' }}" id="row-{{ $testimonial->id }}">
                    <td>#{{ $testimonial->id }}</td>
                    <td>
                        <div class="customer-name">{{ $testimonial->name }}</div>
                        <div class="customer-email">{{ $testimonial->email }}</div>
                    </td>
                    <td>
                        <div class="rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $testimonial->rating)
                                    <svg class="star-filled" width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @else
                                    <svg class="star-empty" width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endif
                            @endfor
                            <span class="rating-number">({{ $testimonial->rating }}/5)</span>
                        </div>
                    </td>
                    <td class="testimonial-message">{{ Str::limit($testimonial->message, 100) }}</td>
                    <td>
                        <span class="{{ $testimonial->is_archived ? 'badge-archived' : 'badge-active' }}">
                            {{ $testimonial->is_archived ? '📦 Diarsipkan' : '✅ Aktif' }}
                        </span>
                    </td>
                    <td class="action-buttons">
                        @if($testimonial->is_archived)
                            <button class="btn-restore" onclick="restoreTestimonial({{ $testimonial->id }})" title="Pulihkan">
                                🔄 Pulihkan
                            </button>
                        @else
                            <button class="btn-archive" onclick="archiveTestimonial({{ $testimonial->id }})" title="Arsipkan">
                                📦 Arsipkan
                            </button>
                        @endif
                        <button class="btn-delete" onclick="deleteTestimonial({{ $testimonial->id }})" title="Hapus">
                            🗑️ Hapus
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <p>Belum ada testimoni</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function archiveTestimonial(id) {
        window.customConfirmAction('📦 Arsipkan testimoni ini? Testimoni akan disembunyikan dari halaman customer.', () => {
            const btn = event.target;
            const originalText = btn.innerHTML;
            btn.innerHTML = '⏳...';
            btn.disabled = true;
            
            fetch(`/admin/testimonial/${id}/archive`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
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
        });
    }
    
    function restoreTestimonial(id) {
        window.customConfirmAction('🔄 Pulihkan testimoni ini? Testimoni akan muncul kembali di halaman customer.', () => {
            const btn = event.target;
            const originalText = btn.innerHTML;
            btn.innerHTML = '⏳...';
            btn.disabled = true;
            
            fetch(`/admin/testimonial/${id}/restore`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
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
        });
    }
    
    function deleteTestimonial(id) {
        window.customConfirmAction('⚠️ Yakin ingin menghapus testimoni ini? Data tidak dapat dikembalikan!', () => {
            const btn = event.target;
            const originalText = btn.innerHTML;
            btn.innerHTML = '⏳...';
            btn.disabled = true;
            
            fetch(`/admin/testimonial/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
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
        });
    }
    
    function filterTestimonials(status) {
        const rows = document.querySelectorAll('#testimonialTableBody tr');
        const buttons = document.querySelectorAll('.filter-btn');
        
        buttons.forEach(btn => {
            btn.classList.remove('active');
            if ((status === 'all' && btn.textContent.trim() === 'Semua') ||
                (status === 'active' && btn.textContent.includes('Aktif')) ||
                (status === 'archived' && btn.textContent.includes('Diarsipkan'))) {
                btn.classList.add('active');
            }
        });
        
        rows.forEach(row => {
            if (row && row.dataset) {
                if (status === 'all' || row.dataset.status === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    }
</script>
@endsection