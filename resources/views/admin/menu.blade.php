{{-- resources/views/admin/menu.blade.php --}}
@extends('layouts.admin')

@section('title', 'Kelola Menu')

@push('styles')
<style>
    /* ==================== COLOR VARIABLES (SAGE THEME) ==================== */
    :root {
        --sage: #8BA888;
        --sage-dark: #6B8A6B;
        --sage-light: #E8F0E6;
        --wood: #A67B5B;
        --wood-dark: #8B5E3C;
        --accent: #D97642;
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
    
    /* ==================== TABLE STYLES ==================== */
    .table-container {
        background: var(--white);
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        border: 1px solid var(--border);
    }
    
    .menu-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .menu-table th {
        padding: 1rem 1rem;
        text-align: left;
        background: var(--light);
        color: var(--wood);
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 2px solid var(--sage);
    }
    
    .menu-table td {
        padding: 1rem;
        color: var(--gray);
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
    }
    
    .menu-table tr:hover td {
        background: var(--sage-light);
    }
    
    /* ==================== IMAGE STYLES ==================== */
    .menu-image-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 0.75rem;
        overflow: hidden;
        background: var(--light);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border);
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    .menu-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .no-image {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--light);
        color: var(--gray);
        font-size: 0.6rem;
        text-align: center;
    }
    
    /* ==================== BADGE CATEGORY ==================== */
    .category-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .category-makanan { background: #E8F0E6; color: var(--sage); }
    .category-snacks { background: #FFF3E0; color: var(--warning); }
    .category-minuman { background: #E0F7FA; color: #00ACC1; }
    .category-jus { background: #F3E5F5; color: #9C27B0; }
    .category-addon { background: #FFEBEE; color: var(--danger); }
    
    /* ==================== STATUS BADGE ==================== */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    
    .status-active {
        background: #E8F5E9;
        color: var(--success);
    }
    
    .status-inactive {
        background: #FFEBEE;
        color: var(--danger);
    }
    
    /* ==================== MENU BADGES ==================== */
    .badge-best-seller {
        background: linear-gradient(135deg, var(--warning), #FF9800);
        color: #fff;
        padding: 0.2rem 0.5rem;
        border-radius: 12px;
        font-size: 0.6rem;
        font-weight: 600;
        margin-left: 0.5rem;
        display: inline-block;
    }
    
    .badge-new {
        background: linear-gradient(135deg, var(--success), #059669);
        color: white;
        padding: 0.2rem 0.5rem;
        border-radius: 12px;
        font-size: 0.6rem;
        font-weight: 600;
        margin-left: 0.5rem;
        display: inline-block;
    }
    
    /* ==================== PRICE STYLE ==================== */
    .price {
        font-weight: 700;
        color: var(--accent);
        font-size: 1rem;
    }
    
    /* ==================== ACTION BUTTONS ==================== */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .btn-edit, .btn-delete, .btn-toggle {
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
    
    .btn-edit {
        background: var(--sage-light);
        color: var(--sage);
    }
    
    .btn-edit:hover {
        background: var(--sage);
        color: white;
        transform: translateY(-2px);
    }
    
    .btn-toggle {
        background: #FFF3E0;
        color: var(--warning);
    }
    
    .btn-toggle:hover {
        background: var(--warning);
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
    
    /* ==================== ALERT ==================== */
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
    
    /* ==================== MODAL STYLES ==================== */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(4px);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }
    
    .modal.show { display: flex; }
    
    .modal-content {
        background: var(--white);
        border-radius: 1.5rem;
        max-width: 600px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        padding: 1.75rem;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        animation: modalFadeIn 0.3s ease;
    }
    
    @keyframes modalFadeIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
    
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--border);
    }
    
    .modal-header h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--wood);
    }
    
    .close-modal {
        background: var(--light);
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        font-size: 1.25rem;
        cursor: pointer;
        color: var(--gray);
        transition: all 0.2s;
    }
    
    .close-modal:hover {
        background: var(--danger);
        color: white;
        transform: rotate(90deg);
    }
    
    /* ==================== FORM STYLES ==================== */
    .form-group {
        margin-bottom: 1.25rem;
    }
    
    .form-label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--wood);
        margin-bottom: 0.5rem;
    }
    
    .form-label span {
        color: var(--danger);
    }
    
    .form-input, .form-select, .form-textarea {
        width: 100%;
        padding: 0.75rem 1rem;
        background: var(--light);
        border: 2px solid var(--border);
        border-radius: 0.75rem;
        color: var(--dark);
        font-family: 'Poppins', sans-serif;
        font-size: 0.875rem;
        transition: all 0.2s;
    }
    
    .form-input:focus, .form-select:focus, .form-textarea:focus {
        outline: none;
        border-color: var(--sage);
        box-shadow: 0 0 0 3px rgba(139, 168, 136, 0.2);
        background: var(--white);
    }
    
    .form-input-file {
        width: 100%;
        padding: 0.75rem;
        background: var(--light);
        border: 2px dashed var(--border);
        border-radius: 0.75rem;
        color: var(--gray);
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .form-input-file:hover {
        border-color: var(--sage);
        background: var(--sage-light);
    }
    
    .preview-image {
        max-width: 100%;
        height: 160px;
        object-fit: cover;
        border-radius: 0.75rem;
        margin-top: 0.75rem;
        border: 2px solid var(--border);
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    
    .btn-submit {
        width: 100%;
        background: linear-gradient(135deg, var(--sage) 0%, var(--wood) 100%);
        color: white;
        padding: 0.875rem;
        border: none;
        border-radius: 0.75rem;
        cursor: pointer;
        font-weight: 600;
        font-size: 1rem;
        margin-top: 1rem;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(139, 168, 136, 0.4);
    }
    
    /* ==================== EMPTY STATE ==================== */
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
        margin-bottom: 1rem;
    }
    
    /* ==================== RESPONSIVE ==================== */
    @media (max-width: 768px) {
        .header-title {
            flex-direction: column;
            text-align: center;
        }
        
        .header-stats {
            flex-direction: column;
        }
        
        .form-row {
            grid-template-columns: 1fr;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn-edit, .btn-delete, .btn-toggle {
            width: 100%;
            justify-content: center;
        }
        
        .menu-table th, .menu-table td {
            padding: 0.75rem;
        }
    }
</style>
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
                <input type="text" name="name" id="name" class="form-input" placeholder="Contoh: Nasi Goreng Spesial" required>
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