{{-- resources/views/admin/promo.blade.php --}}
@extends('admin.layouts.sidebar')

@section('title', 'Kelola Promo')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/promo.css') }}">
@endpush

@section('content')
<div>
    <!-- Header Section -->
    <div class="page-header">
        <div class="header-title">
            <h1>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                </svg>
                Kelola Promo
            </h1>
            <button class="btn-add" onclick="openAddModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18" height="18">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Promo
            </button>
        </div>
        <div class="header-stats">
            <div class="stat-card">
                <div class="stat-number">{{ $promos->count() }}</div>
                <div class="stat-label">Total Promo</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $promos->where('is_active', true)->count() }}</div>
                <div class="stat-label">Promo Aktif</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $promos->where('discount', '>=', 50)->count() }}</div>
                <div class="stat-label">Diskon Besar</div>
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
    
    <!-- Table Section -->
    <div class="table-container">
        <table class="promo-table">
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="10%">Gambar</th>
                    <th width="15%">Nama Promo</th>
                    <th width="20%">Menu Termasuk</th>
                    <th width="8%">Diskon</th>
                    <th width="15%">Periode</th>
                    <th width="8%">Status</th>
                    <th width="12%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($promos as $promo)
                @php
                    $isBigDiscount = $promo->discount >= 50;
                @endphp
                <tr>
                    <td>#{{ $promo->id }}</td>
                    <td>
                        <div class="promo-image-wrapper">
                            @if($promo->image)
                                <img src="{{ $promo->image_url }}" class="promo-image" alt="{{ $promo->name }}" onerror="this.src='/storage/default-promo.jpg'">
                            @else
                                <div class="no-image">No Image</div>
                            @endif
                        </div>
                    </td>
                    <td>
                        <strong style="color: var(--wood);">{{ $promo->name }}</strong>
                        <div class="desc-text" title="{{ $promo->description }}">{{ Str::limit($promo->description, 40) ?? '-' }}</div>
                    </td>
                    <td>
                        <div class="menu-list" style="font-size: 0.8rem; max-height: 60px; overflow-y: auto;">
                            @foreach($promo->menus as $menu)
                                <span style="background: #e5e7eb; padding: 2px 6px; border-radius: 4px; margin: 2px; display: inline-block;">{{ $menu->name }}</span>
                            @endforeach
                            @if($promo->menus->isEmpty())
                                <span style="color: var(--danger);">Belum ada menu</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <span class="discount-badge">
                            🔥 {{ $promo->discount }}% OFF
                        </span>
                    </td>
                    <td>
                        <span class="period-badge">
                            📅 {{ \Carbon\Carbon::parse($promo->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($promo->end_date)->format('d/m/Y') }}
                        </span>
                        @if(\Carbon\Carbon::now()->between($promo->start_date, $promo->end_date))
                            <span style="display: block; font-size: 0.6rem; color: var(--success); margin-top: 0.25rem;">● Sedang Berlangsung</span>
                        @elseif(\Carbon\Carbon::now()->gt($promo->end_date))
                            <span style="display: block; font-size: 0.6rem; color: var(--danger); margin-top: 0.25rem;">● Telah Berakhir</span>
                        @else
                            <span style="display: block; font-size: 0.6rem; color: var(--warning); margin-top: 0.25rem;">● Akan Datang</span>
                        @endif
                     </td>
                    <td>
                        <span class="{{ $promo->is_active ? 'active-badge' : 'inactive-badge' }}">
                            {{ $promo->is_active ? '● Aktif' : '○ Nonaktif' }}
                        </span>
                     </td>
                    <td class="action-buttons">
                        <button class="btn-edit" onclick="editPromo({{ $promo->id }})">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </button>
                        <button class="btn-toggle" onclick="toggleStatus({{ $promo->id }})">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                            {{ $promo->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                        <button class="btn-delete" onclick="deletePromo({{ $promo->id }})">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus
                        </button>
                     </td>
                 </tr>
                @empty
                 <tr>
                    <td colspan="9">
                        <div class="empty-state">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                            </svg>
                            <p>Belum ada promo</p>
                            <button class="btn-add" onclick="openAddModal()" style="margin-top: 1rem; display: inline-flex;">+ Tambah Promo Pertama</button>
                        </div>
                    </td>
                 </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah/Edit Promo -->
<div id="promoModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">Tambah Promo</h3>
            <button class="close-modal" onclick="closeModal()">✕</button>
        </div>
        <form id="promoForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="promo_id" name="promo_id">
            <input type="hidden" id="method" name="_method" value="POST">
            
            <div class="form-group">
                <label class="form-label">Nama Promo <span>*</span></label>
                <input type="text" name="name" id="name" class="form-input" required placeholder="Contoh: Promo Kemerdekaan">
            </div>

            <div class="form-group">
                <label class="form-label">Deskripsi Promo</label>
                <textarea name="description" id="description" class="form-input" rows="2" placeholder="Deskripsi singkat promo..."></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Pilih Menu <span>*</span></label>
                <select name="menus[]" id="menus" class="form-select" required>
                    <option value="">-- Pilih Menu --</option>
                    @foreach($menus as $menu)
                        <option value="{{ $menu->id }}">
                            {{ $menu->name }} - Rp {{ number_format($menu->price, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Diskon (%) <span>*</span></label>
                    <input type="number" name="discount" id="discount" class="form-input" min="1" max="100" placeholder="Contoh: 20" required oninput="calculatePreview()">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="is_active" id="is_active" class="form-select">
                        <option value="1">✅ Aktif</option>
                        <option value="0">❌ Nonaktif</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Mulai <span>*</span></label>
                    <input type="date" name="start_date" id="start_date" class="form-input" required>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Tanggal Selesai <span>*</span></label>
                <input type="date" name="end_date" id="end_date" class="form-input" required>
            </div>
            
            <button type="submit" class="btn-submit">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                </svg>
                Simpan Promo
            </button>
        </form>
    </div>
</div>

<script>
    function calculatePreview() {
        const discount = parseInt(document.getElementById('discount').value) || 0;
        // Hanya sekadar animasi warna
    }
    
    function openAddModal() {
        document.getElementById('modalTitle').innerText = 'Tambah Promo';
        document.getElementById('promoForm').reset();
        document.getElementById('promo_id').value = '';
        document.getElementById('method').value = 'POST';
        // Reset select
        document.getElementById('menus').value = '';
        
        document.getElementById('promoForm').action = "{{ route('admin.promo.store') }}";
        document.getElementById('promoModal').classList.add('show');
    }
    
    function editPromo(id) {
        fetch(`/admin/promo/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('modalTitle').innerText = 'Edit Promo';
                document.getElementById('promo_id').value = data.id;
                document.getElementById('name').value = data.name;
                document.getElementById('description').value = data.description || '';
                
                // Set select
                const select = document.getElementById('menus');
                const selectedMenus = data.menus || [];
                if (selectedMenus.length > 0) {
                    select.value = selectedMenus[0];
                } else {
                    select.value = '';
                }
                
                document.getElementById('discount').value = data.discount || 0;
                document.getElementById('start_date').value = data.start_date;
                document.getElementById('end_date').value = data.end_date;
                document.getElementById('is_active').value = data.is_active ? '1' : '0';
                document.getElementById('method').value = 'PUT';
                
                document.getElementById('promoForm').action = `/admin/promo/${id}`;
                document.getElementById('promoModal').classList.add('show');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal mengambil data promo');
            });
    }
    
    function deletePromo(id) {
        if(confirm('Yakin ingin menghapus promo ini?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/promo/${id}`;
            form.innerHTML = `@csrf @method('DELETE')`;
            document.body.appendChild(form);
            form.submit();
        }
    }
    
    function toggleStatus(id) {
        if(confirm('Ubah status promo ini?')) {
            fetch(`/admin/promo/${id}/toggle`, {
                method: 'PATCH',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            }).then(() => location.reload());
        }
    }
    
    function closeModal() {
        document.getElementById('promoModal').classList.remove('show');
    }
    
    document.getElementById('promoModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
</script>
@endsection