{{-- resources/views/admin/gallery.blade.php --}}
@extends('admin.layouts.sidebar')

@section('title', 'Kelola Galeri')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/gallery.css') }}">
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
                <label class="form-label">Gambar (Maksimal 5) <span>*</span></label>
                <input type="file" name="images[]" id="image" class="form-input-file" accept="image/*" multiple onchange="previewImages(this)">
                <div id="imagePreviewContainer" class="preview-container" style="display: flex; gap: 10px; margin-top: 10px; flex-wrap: wrap;"></div>
                <small style="color: var(--gray); display: block; margin-top: 0.5rem;" id="imageHelpText">
                    📷 Format: JPG, PNG, JPEG, GIF, WEBP (Max 2MB per gambar, Maksimal 5 gambar)
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
    function previewImages(input) {
        const previewContainer = document.getElementById('imagePreviewContainer');
        const helpText = document.getElementById('imageHelpText');
        previewContainer.innerHTML = '';
        
        if (input.files && input.files.length > 0) {
            if (input.files.length > 5) {
                alert('Maksimal hanya 5 gambar yang diperbolehkan!');
                input.value = ''; // Reset input
                return;
            }
            
            for (let i = 0; i < input.files.length; i++) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'preview-image';
                    img.style.width = '80px';
                    img.style.height = '80px';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '4px';
                    previewContainer.appendChild(img);
                }
                reader.readAsDataURL(input.files[i]);
            }
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
        document.getElementById('imagePreviewContainer').innerHTML = '';
        document.getElementById('method').value = 'POST';
        document.getElementById('galleryForm').action = "{{ route('admin.gallery.store') }}";
        document.getElementById('galleryModal').classList.add('show');
    }
    
    function editGallery(id) {
        fetch(`/admin/gallery/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('modalTitle').innerText = 'Edit Galeri';
                document.getElementById('gallery_id').value = data.id;
                document.getElementById('title').value = data.title;
                document.getElementById('category').value = data.category;
                document.getElementById('description').value = data.description || '';
                document.getElementById('imagePreviewContainer').innerHTML = '';
                
                // Show existing images if any
                const previewContainer = document.getElementById('imagePreviewContainer');
                if (data.images && data.images.length > 0) {
                    data.images.forEach(imgPath => {
                        const img = document.createElement('img');
                        img.src = '/' + imgPath;
                        img.className = 'preview-image';
                        img.style.width = '80px';
                        img.style.height = '80px';
                        img.style.objectFit = 'cover';
                        img.style.borderRadius = '4px';
                        previewContainer.appendChild(img);
                    });
                } else if (data.image) {
                    const img = document.createElement('img');
                    img.src = '/' + data.image;
                    img.className = 'preview-image';
                    img.style.width = '80px';
                    img.style.height = '80px';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '4px';
                    previewContainer.appendChild(img);
                }
                
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