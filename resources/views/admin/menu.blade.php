{{-- resources/views/admin/menu.blade.php --}}
@extends('admin.layouts.sidebar')

@section('title', 'Kelola Menu')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/menu.css') }}">
@endpush

@section('content')
<div>
    <!-- Header Section -->
    <div class="page-header">
        <div class="header-title">
            <h1>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                Kelola Menu
            </h1>
            <button class="btn-add" onclick="openAddModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18" height="18">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Menu Baru
            </button>
        </div>
        <div class="header-stats">
            <div class="stat-card">
                <div class="stat-number">{{ $menus->count() }}</div>
                <div class="stat-label">Total Menu</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $menus->where('is_available', true)->count() }}</div>
                <div class="stat-label">Tersedia</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $menus->where('is_available', false)->count() }}</div>
                <div class="stat-label">Tidak Tersedia</div>
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
                    <th width="15%">Kategori</th>
                    <th width="10%">Harga</th>
                    <th width="10%">Status</th>
                    <th width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($menus as $menu)
                <tr>
                    <td>#{{ $menu->id }}</td>
                    <td>
                        <div class="menu-image-wrapper">
                            @if($menu->image)
                                <img src="{{ asset($menu->image) }}" class="menu-image" alt="{{ $menu->name }}">
                            @else
                                <div class="no-image">No Image</div>
                            @endif
                        </div>
                    </td>
                    <td>
                        <strong style="color: var(--wood);">{{ $menu->name }}</strong>
                        @if($menu->badge == 'best-seller')
                            <span class="badge-best-seller">⭐ Best Seller</span>
                        @elseif($menu->badge == 'new')
                            <span class="badge-new">✨ Baru</span>
                        @endif
                    </td>
                    <td>
                        @php
                            $categoryClass = '';
                            if(in_array($menu->category, ['minuman-hot', 'minuman-cold'])) $categoryClass = 'category-minuman';
                            elseif(in_array($menu->category, ['jus-hot', 'jus-cold'])) $categoryClass = 'category-jus';
                            else $categoryClass = 'category-' . $menu->category;
                        @endphp
                        <span class="category-badge {{ $categoryClass }}">
                            {{ ucfirst(str_replace('-', ' ', $menu->category)) }}
                        </span>
                    </td>
                    <td class="price">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                    <td>
                        <span class="status-badge {{ $menu->is_available ? 'status-active' : 'status-inactive' }}">
                            {{ $menu->is_available ? '● Tersedia' : '○ Tidak Tersedia' }}
                        </span>
                    </td>
                    <td class="action-buttons">
                        <button class="btn-edit" onclick="editMenu({{ $menu->id }})">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </button>
                        <button class="btn-toggle" onclick="toggleStatus({{ $menu->id }})">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                            {{ $menu->is_available ? 'Nonaktif' : 'Aktif' }}
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
                    <td colspan="7">
                        <div class="empty-state">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 0h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p>Belum ada menu</p>
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
            <h3 id="modalTitle">Tambah Menu</h3>
            <button class="close-modal" onclick="closeModal()">✕</button>
        </div>
        <form id="menuForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="menuId" name="menu_id">
            <input type="hidden" id="method" name="_method" value="POST">
            
            <div class="form-group">
                <label class="form-label">Nama Menu <span>*</span></label>
                <input type="text" name="name" id="name" class="form-input" placeholder="Contoh: Nasi Goreng" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Deskripsi <span>*</span></label>
                <textarea name="description" id="description" class="form-textarea" rows="3" placeholder="Deskripsi menu..." required></textarea>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Harga <span>*</span></label>
                    <input type="number" name="price" id="price" class="form-input" min="1000" step="1000" placeholder="Rp 0" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Kategori <span>*</span></label>
                    <select name="category" id="category" class="form-select" required>
                        <option value="makanan">Makanan</option>
                        <option value="snacks">Snacks</option>
                        <option value="minuman-hot">Minuman Panas</option>
                        <option value="minuman-cold"> Minuman Dingin</option>
                        <option value="jus-hot">Jus Panas</option>
                        <option value="jus-cold">Jus Dingin</option>
                        <option value="addon">Add On</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Badge (Label Khusus)</label>
                <select name="badge" id="badge" class="form-select">
                    <option value="">Tidak Ada</option>
                    <option value="best-seller">⭐ Best Seller</option>
                    <option value="new">✨ Baru</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Gambar Menu <span>*</span></label>
                <input type="file" name="image" id="image" class="form-input-file" accept="image/*" onchange="previewImage(this)">
                <img id="imagePreview" class="preview-image" style="display: none;">
                <small style="color: var(--gray); display: block; margin-top: 0.5rem;">
                    📷 Format: JPG, PNG, JPEG, GIF, WEBP (Max 2MB)
                </small>
            </div>
            
            <button type="submit" class="btn-submit">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                </svg>
                Simpan Menu
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
        document.getElementById('modalTitle').innerText = 'Tambah Menu';
        document.getElementById('menuForm').reset();
        document.getElementById('menuId').value = '';
        document.getElementById('imagePreview').style.display = 'none';
        document.getElementById('method').value = 'POST';
        document.getElementById('menuForm').action = "{{ route('admin.menu.store') }}";
        document.getElementById('menuModal').classList.add('show');
    }
    
    function editMenu(id) {
        fetch(`/admin/menu/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('modalTitle').innerText = 'Edit Menu';
                document.getElementById('menuId').value = data.id;
                document.getElementById('name').value = data.name;
                document.getElementById('description').value = data.description;
                document.getElementById('price').value = data.price;
                document.getElementById('category').value = data.category;
                document.getElementById('badge').value = data.badge || '';
                document.getElementById('imagePreview').style.display = 'none';
                document.getElementById('method').value = 'PUT';
                document.getElementById('menuForm').action = `/admin/menu/${id}`;
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
            form.action = `/admin/menu/${id}`;
            form.innerHTML = `@csrf @method('DELETE')`;
            document.body.appendChild(form);
            form.submit();
        }
    }
    
    function toggleStatus(id) {
        if(confirm('Ubah status ketersediaan menu ini?')) {
            fetch(`/admin/menu/${id}/toggle-available`, {
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