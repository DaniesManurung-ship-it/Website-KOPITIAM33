@extends('layouts.admin')

@section('title', 'Kelola Testimoni')

@push('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .stat-card {
        background: var(--cream);
        border-radius: 0.75rem;
        padding: 1rem;
        text-align: center;
    }
    .stat-number {
        font-size: 1.5rem;
        font-weight: bold;
        color: var(--wood);
    }
    .stat-label {
        font-size: 0.75rem;
        color: #6b7280;
    }
    .testimonial-table {
        width: 100%;
        background: white;
        border-radius: 1rem;
        overflow-x: auto;
    }
    .testimonial-table table {
        width: 100%;
        border-collapse: collapse;
    }
    .testimonial-table th, .testimonial-table td {
        padding: 0.75rem;
        text-align: left;
        border-bottom: 1px solid #f3f4f6;
    }
    .testimonial-table th {
        background: var(--cream);
    }
    .rating { color: #fbbf24; font-size: 0.8rem; }
    .badge-active { background: #d1fae5; color: #065f46; padding: 0.25rem 0.5rem; border-radius: 20px; font-size: 0.7rem; display: inline-block; }
    .badge-archived { background: #f3f4f6; color: #6b7280; padding: 0.25rem 0.5rem; border-radius: 20px; font-size: 0.7rem; display: inline-block; }
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    .btn-archive, .btn-delete {
        padding: 0.25rem 0.5rem;
        border-radius: 0.375rem;
        border: none;
        cursor: pointer;
        font-size: 0.7rem;
    }
    .btn-archive { background: #f59e0b; color: white; }
    .btn-delete { background: #ef4444; color: white; }
    .alert-success {
        background: #d1fae5;
        color: #065f46;
        padding: 0.75rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
    }
    .filter-buttons {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }
    .filter-btn {
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        border: none;
        cursor: pointer;
        background: #f3f4f6;
        transition: all 0.3s;
    }
    .filter-btn.active {
        background: var(--sage);
        color: white;
    }
</style>
@endpush

@section('content')
<div>
    <h1 style="font-family: Playfair Display, serif; font-size: 1.75rem; color: var(--wood); margin-bottom: 1.5rem;">Kelola Testimoni</h1>
    
    <div class="stats-grid">
        <div class="stat-card"><div class="stat-number">{{ $testimonials->count() }}</div><div class="stat-label">Total Testimoni</div></div>
        <div class="stat-card"><div class="stat-number">{{ $activeCount ?? 0 }}</div><div class="stat-label">Aktif</div></div>
        <div class="stat-card"><div class="stat-number">{{ $archivedCount ?? 0 }}</div><div class="stat-label">Diarsipkan</div></div>
    </div>
    
    @if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="filter-buttons">
        <button class="filter-btn active" data-filter="all">Semua</button>
        <button class="filter-btn" data-filter="active">Aktif</button>
        <button class="filter-btn" data-filter="archived">Diarsipkan</button>
    </div>
    
    <div class="testimonial-table">
        <table id="testimonialTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Rating</th>
                    <th>Testimoni</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($testimonials as $testimonial)
                <tr data-archived="{{ $testimonial->is_archived ? 'archived' : 'active' }}">
                    <td>{{ $testimonial->id }}</td>
                    <td>
                        <strong>{{ $testimonial->name }}</strong><br>
                        <small>{{ $testimonial->email }}</small>
                    </td>
                    <td>
                        <div class="rating">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $testimonial->rating) ★ @else ☆ @endif
                            @endfor
                        </div>
                    </td>
                    <td>{{ Str::limit($testimonial->message, 100) }}</td>
                    <td>
                        <span class="{{ $testimonial->is_archived ? 'badge-archived' : 'badge-active' }}">
                            {{ $testimonial->is_archived ? 'Diarsipkan' : 'Aktif' }}
                        </span>
                    </td>
                    <td class="action-buttons">
                        <button class="btn-archive" onclick="archiveTestimonial({{ $testimonial->id }})">
                            {{ $testimonial->is_archived ? 'Pulihkan' : 'Arsipkan' }}
                        </button>
                        <button class="btn-delete" onclick="deleteTestimonial({{ $testimonial->id }})">Hapus</button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align: center;">Belum ada testimoni</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function archiveTestimonial(id) {
        if(confirm('Arsipkan testimoni ini?')) {
            fetch(`/admin/testimonial/${id}/archive`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) location.reload();
            });
        }
    }
    
    function deleteTestimonial(id) {
        if(confirm('Yakin ingin menghapus testimoni ini?')) {
            fetch(`/admin/testimonial/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            }).then(() => location.reload());
        }
    }
    
    // Filter functionality
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const filter = this.dataset.filter;
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const rows = document.querySelectorAll('#testimonialTable tbody tr');
            rows.forEach(row => {
                if (filter === 'all') {
                    row.style.display = '';
                } else if (filter === 'active') {
                    row.style.display = row.dataset.archived === 'active' ? '' : 'none';
                } else if (filter === 'archived') {
                    row.style.display = row.dataset.archived === 'archived' ? '' : 'none';
                }
            });
        });
    });
</script>
@endsection