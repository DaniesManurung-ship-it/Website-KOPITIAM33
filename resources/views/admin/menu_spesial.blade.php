{{-- resources/views/admin/menu_spesial.blade.php --}}
@extends('admin.layouts.sidebar')

@section('title', 'Menu Spesial')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/menu_spesial.css') }}">
@endpush

@section('content')
<div>
    <!-- Header Section -->
    <div class="page-header">
        <div class="header-title">
            <h1>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
                Menu Spesial
            </h1>
            <button class="btn-add" onclick="openAddModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18" height="18">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Menu Spesial
            </button>
        </div>
        <div class="header-stats">
            <div class="stat-card">
                <div class="stat-number">{{ $spesialMenus->count() }}</div>
                <div class="stat-label">Total Menu</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $spesialMenus->where('is_featured', true)->count() }}</div>
                <div class="stat-label">Menu Unggulan</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $spesialMenus->where('is_active', true)->count() }}</div>
                <div class="stat-label">Aktif</div>
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
        <table class="menu-table">
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="10%">Gambar</th>
                    <th width="20%">Nama Menu</th>
                    <th width="20%">Deskripsi</th>
                    <th width="10%">Harga</th>
                    <th width="10%">Badge</th>
                    <th width="10%">Status</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($spesialMenus as $menu)
                <tr>
                    <td>#{{ $menu->id }}</td>
                    <td>
                        <div class="menu-image-wrapper">
                            @if($menu->image)
                                <img src="{{ asset($menu->image) }}" class="menu-image" alt="{{ $menu->name }}" onerror="this.src='/uploads/default/default-menu.jpg'">
                            @else
                                <div class="no-image">No Image</div>
                            @endif
                        </div>
                    </td>
                    <td>
                        <strong style="color: var(--wood);">{{ $menu->name }}</strong>
                        @if($menu->is_featured)
                            <div style="margin-top: 0.25rem;">
                                <span class="badge-menu">⭐ Unggulan</span>
                            </div>
                        @endif
                    </td>
                    <td class="desc-text" title="{{ $menu->description }}">{{ Str::limit($menu->description, 60) ?? '-' }}</td>
                    <td class="price">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                    <td>
                        @if($menu->badge)
                            <span class="active-badge" style="background: linear-gradient(135deg, var(--accent) 0%, var(--wood) 100%);">
                                {{ $menu->badge }}
                            </span>
                        @else
                            <span class="badge-menu">-</span>
                        @endif
                    </td>
                    <td>
                        <span class="{{ $menu->is_active ? 'active-badge' : 'inactive-badge' }}">
                            {{ $menu->is_active ? '● Aktif' : '○ Nonaktif' }}
                        </span>
                    </td>
                    <td class="action-buttons">
                        <button class="btn-edit" onclick="editMenu({{ $menu->id }})">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </button>
                        <button class="btn-featured" onclick="toggleFeatured({{ $menu->id }})">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                            {{ $menu->is_featured ? 'Hapus Unggulan' : 'Jadikan Unggulan' }}
                        </button>
                        <button class="btn-toggle" onclick="toggleStatus({{ $menu->id }})">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                            {{ $menu->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                        <button class="btn-delete" onclick="deleteMenu({{ $menu->id }})">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                            <p>Belum ada menu spesial</p>
                            <button class="btn-add" onclick="openAddModal()" style="margin-top: 1rem; display: inline-flex;">+ Tambah Menu Spesial Pertama</button>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah/Edit Menu -->
<div id="menuModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">Tambah Menu Spesial</h3>
            <button class="close-modal" onclick="closeModal()">✕</button>
        </div>
        <form id="menuForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="menu_id" name="menu_id">
            <input type="hidden" id="method" name="_method" value="POST">
            
            <div class="form-group">
                <label class="form-label">Nama Menu <span>*</span></label>
                <input type="text" name="name" id="name" class="form-input" placeholder="Contoh: Ayam Goreng" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Gambar Menu <span>*</span></label>
                <input type="file" name="image" id="image" class="form-input-file" accept="image/*" onchange="previewImage(this)">
                <img id="imagePreview" class="preview-image" style="display: none;">
                <small style="color: var(--gray); display: block; margin-top: 0.5rem;">
                    📷 Format: JPG, PNG, JPEG, GIF, WEBP (Max 2MB)
                </small>
            </div>
            
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" id="description" class="form-textarea" rows="3" placeholder="Deskripsi menu spesial..."></textarea>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Harga <span>*</span></label>
                    <input type="number" name="price" id="price" class="form-input" min="1000" step="1000" placeholder="Rp 0" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Badge (Label)</label>
                    <select name="badge" id="badge" class="form-select">
                        <option value="">Tidak Ada</option>
                        <option value="Signature">✨ Signature</option>
                        <option value="Premium">⭐ Premium</option>
                        <option value="Limited">🔥 Limited Edition</option>
                        <option value="Chef Recomendation">👨‍🍳 Chef Recomendation</option>
                    </select>
                </div>
            </div>
            
            <div class="checkbox-group">
                <input type="checkbox" name="is_featured" id="is_featured" value="1">
                <label for="is_featured">⭐ Jadikan sebagai Menu Unggulan (Signature Dish)</label>
            </div>
            
            <button type="submit" class="btn-submit">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                </svg>
                Simpan Menu Spesial
            </button>
        </form>
    </div>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    function openAddModal() {
        document.getElementById('modalTitle').innerText = 'Tambah Menu Spesial';
        document.getElementById('menuForm').reset();
        document.getElementById('menu_id').value = '';
        document.getElementById('imagePreview').style.display = 'none';
        document.getElementById('method').value = 'POST';
        document.getElementById('menuForm').action = "{{ route('admin.menu-spesial.store') }}";
        document.getElementById('menuModal').classList.add('show');
    }
    
    function editMenu(id) {
        fetch(`/admin/menu-spesial/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('modalTitle').innerText = 'Edit Menu Spesial';
                document.getElementById('menu_id').value = data.id;
                document.getElementById('name').value = data.name;
                document.getElementById('description').value = data.description || '';
                // PERBAIKAN: Hapus .00 dengan mengubah ke integer/parseInt
                document.getElementById('price').value = parseInt(data.price) || 0;
                document.getElementById('badge').value = data.badge || '';
                document.getElementById('is_featured').checked = data.is_featured === 1;
                document.getElementById('imagePreview').style.display = 'none';
                document.getElementById('method').value = 'PUT';
                document.getElementById('menuForm').action = `/admin/menu-spesial/${id}`;
                document.getElementById('menuModal').classList.add('show');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal mengambil data menu');
            });
    }
    
    function deleteMenu(id) {
        if(confirm('Yakin ingin menghapus menu ini?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/menu-spesial/${id}`;
            form.innerHTML = `@csrf @method('DELETE')`;
            document.body.appendChild(form);
            form.submit();
        }
    }
    
    function toggleFeatured(id) {
        if(confirm('Ubah status unggulan menu ini?')) {
            fetch(`/admin/menu-spesial/${id}/toggle-featured`, {
                method: 'PATCH',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            }).then(() => location.reload());
        }
    }
    
    function toggleStatus(id) {
        if(confirm('Ubah status menu ini?')) {
            fetch(`/admin/menu-spesial/${id}/toggle-status`, {
                method: 'PATCH',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            }).then(() => location.reload());
        }
    }
    
    function closeModal() {
        document.getElementById('menuModal').classList.remove('show');
    }
    
    document.getElementById('menuModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
</script>
@endsection