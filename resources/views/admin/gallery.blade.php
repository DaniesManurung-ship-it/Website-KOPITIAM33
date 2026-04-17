{{-- resources/views/admin/gallery.blade.php --}}
@extends('layouts.admin')

@section('title', 'Kelola Galeri')

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
        padding: 1rem;
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
    
    /* ==================== GALLERY GRID ==================== */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }
    
    .gallery-card {
        background: var(--white);
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        border: 1px solid var(--border);
        position: relative;
    }
    
    .gallery-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.12);
    }
    
    .gallery-image-wrapper {
        position: relative;
        overflow: hidden;
        height: 200px;
    }
    
    .gallery-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .gallery-card:hover .gallery-image {
        transform: scale(1.05);
    }
    
    .gallery-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .gallery-card:hover .gallery-overlay {
        opacity: 1;
    }
    
    .overlay-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    
    .overlay-btn.edit {
        background: var(--sage);
        color: white;
    }
    
    .overlay-btn.edit:hover {
        background: var(--wood);
        transform: scale(1.1);
    }
    
    .overlay-btn.delete {
        background: var(--danger);
        color: white;
    }
    
    .overlay-btn.delete:hover {
        background: #dc2626;
        transform: scale(1.1);
    }
    
    .gallery-info {
        padding: 1rem;
    }
    
    .gallery-title {
        font-weight: 700;
        color: var(--wood);
        font-size: 1rem;
        margin-bottom: 0.25rem;
    }
    
    .gallery-category {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        background: var(--sage-light);
        color: var(--sage);
        padding: 0.2rem 0.6rem;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .gallery-description {
        font-size: 0.75rem;
        color: var(--gray);
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Category Badge Colors */
    .category-interior { background: #E8F0E6; color: var(--sage); }
    .category-food { background: #FEF3C7; color: #D97706; }
    .category-drink { background: #E0F7FA; color: #00ACC1; }
    .category-event { background: #F3E5F5; color: #9C27B0; }
    .category-chef { background: #FFEBEE; color: var(--danger); }
    
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
        max-width: 550px;
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
    
    /* Form Styles */
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
        background: var(--white);
        border-radius: 1rem;
        border: 1px solid var(--border);
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
        
        .gallery-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Kelola Galeri
            </h1>
            <button class="btn-add" onclick="openAddModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18" height="18">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Gambar
            </button>
        </div>
        <div class="header-stats">
            <div class="stat-card">
                <div class="stat-number">{{ $galleries->count() }}</div>
                <div class="stat-label">Total Gambar</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $galleries->groupBy('category')->count() }}</div>
                <div class="stat-label">Kategori</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $galleries->where('created_at', '>=', now()->subDays(7))->count() }}</div>
                <div class="stat-label">Minggu Ini</div>
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
        <span class="filter-label">Filter Kategori:</span>
        <button class="filter-btn active" onclick="filterGallery('all')">Semua</button>
        <button class="filter-btn" onclick="filterGallery('interior')">🏠 Interior</button>
        <button class="filter-btn" onclick="filterGallery('food')">🍽️ Makanan</button>
        <button class="filter-btn" onclick="filterGallery('drink')">🥤 Minuman</button>
        <button class="filter-btn" onclick="filterGallery('event')">🎉 Acara</button>
        <button class="filter-btn" onclick="filterGallery('chef')">👨‍🍳 Chef</button>
    </div>
    
    <!-- Gallery Grid -->
    <div class="gallery-grid" id="galleryGrid">
        @forelse($galleries as $gallery)
        <div class="gallery-card" data-category="{{ $gallery->category }}">
            <div class="gallery-image-wrapper">
                <img src="{{ asset($gallery->image) }}" alt="{{ $gallery->title }}" class="gallery-image">
                <div class="gallery-overlay">
                    <button class="overlay-btn edit" onclick="editGallery({{ $gallery->id }})">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </button>
                    <button class="overlay-btn delete" onclick="deleteGallery({{ $gallery->id }})">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="gallery-info">
                <h4 class="gallery-title">{{ $gallery->title }}</h4>
                <span class="gallery-category category-{{ $gallery->category }}">
                    @if($gallery->category == 'interior') 🏠 Interior
                    @elseif($gallery->category == 'food') 🍽️ Makanan
                    @elseif($gallery->category == 'drink') 🥤 Minuman
                    @elseif($gallery->category == 'event') 🎉 Acara
                    @elseif($gallery->category == 'chef') 👨‍🍳 Chef
                    @endif
                </span>
                <p class="gallery-description">{{ Str::limit($gallery->description ?? 'Tidak ada deskripsi', 80) }}</p>
            </div>
        </div>
        @empty
        <div class="empty-state" style="grid-column: 1/-1;">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p>Belum ada gambar di galeri</p>
            <button class="btn-add" onclick="openAddModal()" style="margin-top: 1rem; display: inline-flex;">+ Tambah Gambar Pertama</button>
        </div>
        @endforelse
    </div>
</div>

<!-- Modal Tambah/Edit -->
<div id="galleryModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">Tambah Gambar</h3>
            <button class="close-modal" onclick="closeModal()">✕</button>
        </div>
        <form id="galleryForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="gallery_id" name="gallery_id">
            <input type="hidden" id="method" name="_method" value="POST">
            
            <div class="form-group">
                <label class="form-label">Judul <span>*</span></label>
                <input type="text" name="title" id="title" class="form-input" placeholder="Contoh: Suasana Interior Café" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Gambar <span>*</span></label>
                <input type="file" name="image" id="image" class="form-input-file" accept="image/*" onchange="previewImage(this)">
                <img id="imagePreview" class="preview-image" style="display: none;">
                <small style="color: var(--gray); display: block; margin-top: 0.5rem;">
                    📷 Format: JPG, PNG, JPEG, GIF, WEBP (Max 2MB)
                </small>
            </div>
            
            <div class="form-group">
                <label class="form-label">Kategori <span>*</span></label>
                <select name="category" id="category" class="form-select" required>
                    <option value="interior">🏠 Interior Café</option>
                    <option value="food">🍽️ Makanan</option>
                    <option value="drink">🥤 Minuman</option>
                    <option value="event">🎉 Acara & Event</option>
                    <option value="chef">👨‍🍳 Chef & Tim</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" id="description" class="form-textarea" rows="3" placeholder="Deskripsi gambar..."></textarea>
            </div>
            
            <button type="submit" class="btn-submit">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                </svg>
                Simpan Gambar
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
    
    function filterGallery(category) {
        const cards = document.querySelectorAll('.gallery-card');
        const buttons = document.querySelectorAll('.filter-btn');
        
        buttons.forEach(btn => {
            btn.classList.remove('active');
            if (btn.textContent.toLowerCase().includes(category) || (category === 'all' && btn.textContent === 'Semua')) {
                btn.classList.add('active');
            }
        });
        
        cards.forEach(card => {
            if (category === 'all' || card.dataset.category === category) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
    
    function openAddModal() {
        document.getElementById('modalTitle').innerText = 'Tambah Gambar';
        document.getElementById('galleryForm').reset();
        document.getElementById('gallery_id').value = '';
        document.getElementById('imagePreview').style.display = 'none';
        document.getElementById('method').value = 'POST';
        document.getElementById('galleryForm').action = "{{ route('admin.gallery.store') }}";
        document.getElementById('galleryModal').classList.add('show');
    }
    
    function editGallery(id) {
        fetch(`/admin/gallery/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('modalTitle').innerText = 'Edit Gambar';
                document.getElementById('gallery_id').value = data.id;
                document.getElementById('title').value = data.title;
                document.getElementById('category').value = data.category;
                document.getElementById('description').value = data.description || '';
                document.getElementById('imagePreview').style.display = 'none';
                document.getElementById('method').value = 'PUT';
                document.getElementById('galleryForm').action = `/admin/gallery/${id}`;
                document.getElementById('galleryModal').classList.add('show');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal mengambil data gambar');
            });
    }
    
    function deleteGallery(id) {
        if(confirm('Yakin ingin menghapus gambar ini?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/gallery/${id}`;
            form.innerHTML = `@csrf @method('DELETE')`;
            document.body.appendChild(form);
            form.submit();
        }
    }
    
    function closeModal() {
        document.getElementById('galleryModal').classList.remove('show');
    }
    
    document.getElementById('galleryModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
</script>
@endsection