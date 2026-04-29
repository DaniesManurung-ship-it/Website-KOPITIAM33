@extends('admin.layouts.sidebar')

@section('title', 'Kelola Testimoni')

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
    
    .header-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
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
    
    .header-title h1 svg {
        width: 28px;
        height: 28px;
    }
    
    .header-stats {
        display: flex;
        gap: 1rem;
        margin-top: 1.25rem;
        padding-top: 1.25rem;
        border-top: 1px solid rgba(255,255,255,0.2);
    }
    
    .stat-card {
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(10px);
        border-radius: 0.75rem;
        padding: 0.75rem 1.25rem;
        text-align: center;
        flex: 1;
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
        background: rgba(255,255,255,0.25);
    }
    
    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--white);
        font-family: 'Poppins', sans-serif;
    }
    
    .stat-label {
        font-size: 0.7rem;
        color: rgba(255,255,255,0.9);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-top: 0.25rem;
    }
    
    /* ==================== BUTTON PRIMARY ==================== */
    .btn-add {
        background: linear-gradient(135deg, var(--accent) 0%, var(--wood) 100%);
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 0.75rem;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(217, 118, 66, 0.3);
    }
    
    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(217, 118, 66, 0.4);
    }
    
    /* ==================== FILTER SECTION ==================== */
    .filter-section {
        background: var(--white);
        border-radius: 1rem;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
        border: 1px solid var(--border);
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        align-items: center;
    }
    
    .filter-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--wood);
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .filter-btn {
        padding: 0.4rem 1rem;
        border-radius: 2rem;
        border: none;
        cursor: pointer;
        font-size: 0.75rem;
        font-weight: 500;
        transition: all 0.2s;
        background: var(--light);
        color: var(--gray);
    }
    
    .filter-btn:hover {
        background: var(--sage-light);
        color: var(--sage);
    }
    
    .filter-btn.active {
        background: linear-gradient(135deg, var(--sage) 0%, var(--wood) 100%);
        color: white;
    }
    
    /* ==================== TABLE STYLES ==================== */
    .table-container {
        background: var(--white);
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        border: 1px solid var(--border);
    }
    
    .testimonial-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }
    
    .testimonial-table th {
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
    
    .testimonial-table td {
        padding: 1rem;
        color: var(--gray);
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
    }
    
    .testimonial-table tr:hover td {
        background: var(--sage-light);
    }
    
    /* Customer Info */
    .customer-name {
        font-weight: 600;
        color: var(--wood);
        font-size: 0.85rem;
        margin-bottom: 0.25rem;
    }
    
    .customer-email {
        font-size: 0.7rem;
        color: var(--gray);
        word-break: break-all;
    }
    
    /* Rating Stars */
    .rating-stars {
        display: flex;
        gap: 0.2rem;
        align-items: center;
    }
    
    .star-filled {
        color: #fbbf24;
    }
    
    .star-empty {
        color: #d1d5db;
    }
    
    .rating-number {
        font-size: 0.7rem;
        color: var(--gray);
        margin-left: 0.25rem;
    }
    
    /* Message */
    .testimonial-message {
        max-width: 300px;
        white-space: normal;
        word-wrap: break-word;
        line-height: 1.4;
        font-size: 0.8rem;
    }
    
    /* Badge Styles */
    .badge-active {
        background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .badge-archived {
        background: linear-gradient(135deg, var(--gray) 0%, #4B5563 100%);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .btn-archive, .btn-delete, .btn-restore {
        padding: 0.4rem 0.8rem;
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
    
    .btn-archive {
        background: #FFF3E0;
        color: #D97706;
    }
    
    .btn-archive:hover {
        background: #D97706;
        color: white;
        transform: translateY(-2px);
    }
    
    .btn-restore {
        background: var(--sage-light);
        color: var(--sage);
    }
    
    .btn-restore:hover {
        background: var(--sage);
        color: white;
        transform: translateY(-2px);
    }
    
    .btn-delete {
        background: #FFEBEE;
        color: var(--danger);
    }
    
    .btn-delete:hover {
        background: var(--danger);
        color: white;
        transform: translateY(-2px);
    }
    
    /* Alert */
    .alert-success {
        background: linear-gradient(135deg, #E8F5E9, #C8E6C9);
        color: #059669;
        padding: 1rem;
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid var(--success);
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
    
    .empty-state p {
        color: var(--gray);
        font-size: 0.9rem;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .header-title {
            flex-direction: column;
            text-align: center;
        }
        
        .header-stats {
            flex-direction: column;
        }
        
        .filter-section {
            justify-content: center;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn-archive, .btn-delete, .btn-restore {
            width: 100%;
            justify-content: center;
        }
        
        .testimonial-message {
            max-width: 200px;
        }
    }
</style>
@endpush

@section('content')
<div>
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
        if(confirm('📦 Arsipkan testimoni ini? Testimoni akan disembunyikan dari halaman customer.')) {
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
        }
    }
    
    function restoreTestimonial(id) {
        if(confirm('🔄 Pulihkan testimoni ini? Testimoni akan muncul kembali di halaman customer.')) {
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
        }
    }
    
    function deleteTestimonial(id) {
        if(confirm('⚠️ Yakin ingin menghapus testimoni ini? Data tidak dapat dikembalikan!')) {
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
        }
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