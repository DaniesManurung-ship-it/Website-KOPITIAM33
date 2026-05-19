{{-- resources/views/galeri.blade.php --}}
@extends('layouts.app')

@section('title', 'Galeri - Café Kopitiam33')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/gallery.css') }}">
@endpush

@section('content')
<!-- HEADER -->
<section class="gallery-header">
    <div class="container">
        <h1>📸 Galeri Kami</h1>
        <p>Jelajahi momen terbaik, hidangan istimewa, dan suasana hangat Café Kopitiam33</p>
    </div>
</section>

<!-- FILTER SECTION -->
<section class="filter-section">
    <div class="container">
        <div class="filter-wrapper">
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">Semua</button>
                <button class="filter-btn" data-filter="interior">🏠 Interior</button>
                <button class="filter-btn" data-filter="food">🍽️ Makanan</button>
                <button class="filter-btn" data-filter="drink">☕ Minuman</button>
                <button class="filter-btn" data-filter="event">🎉 Acara</button>
                <button class="filter-btn" data-filter="chef">👨‍🍳 Chef</button>
            </div>
        </div>
    </div>
</section>

<!-- GALLERY GRID -->
<section class="section">
    <div class="container">
        <div class="gallery-grid" id="galleryContainer"></div>
        <div class="pagination" id="pagination"></div>
    </div>
</section>

<!-- LIGHTBOX MODAL -->
<div id="lightboxModal" class="lightbox-modal">
    <button class="close-btn" id="closeLightbox">✕</button>
    <button class="nav-btn prev" id="prevBtn">‹</button>
    <button class="nav-btn next" id="nextBtn">›</button>
    <div class="lightbox-content">
        <img id="lightboxImage" class="lightbox-image" src="" alt="">
        <div class="lightbox-caption">
            <h3 id="lightboxTitle" class="lightbox-title"></h3>
            <p id="lightboxDesc" class="lightbox-description"></p>
            <span id="lightboxCategory" class="lightbox-category"></span>
        </div>
    </div>
</div>

<script>
    // Data dari database (hanya galeri yang diupload admin)
    const galleryItems = @json($galleries);
    
    let currentFilter = 'all';
    let currentPage = 1;
    const itemsPerPage = 12;
    let currentLightboxIndex = 0;
    let filteredItems = [...galleryItems];
    
    function getCategoryName(category) {
        const categories = {
            'interior': '🏠 Interior',
            'food': '🍽️ Makanan',
            'drink': '☕ Minuman',
            'event': '🎉 Acara',
            'chef': '👨‍🍳 Chef'
        };
        return categories[category] || '📷 Lainnya';
    }
    
    function getImageUrl(image) {
        if (!image) return '/storage/default-menu.jpg';
        if (image.startsWith('http')) return image;
        if (image.startsWith('/storage/')) return image;
        if (image.startsWith('storage/')) return '/' + image;
        if (image.startsWith('uploads/')) return '/' + image;
        return '/storage/' + image;
    }
    
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    function renderGallery() {
        const container = document.getElementById('galleryContainer');
        if (!container) return;
        
        filteredItems = galleryItems.filter(item => 
            currentFilter === 'all' || item.category === currentFilter
        );
        
        // Pagination logic
        const startIndex = (currentPage - 1) * itemsPerPage;
        const paginatedItems = filteredItems.slice(startIndex, startIndex + itemsPerPage);
        
        let htmlContent = '';
        
        if (paginatedItems.length === 0) {
            htmlContent = `
                <div class="empty-state">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <h3>Belum Ada Galeri</h3>
                    <p>Belum ada foto galeri yang tersedia saat ini.</p>
                </div>
            `;
        } else {
            paginatedItems.forEach((item, idx) => {
                const imageUrl = getImageUrl(item.image);
                const globalIndex = filteredItems.findIndex(i => i.id === item.id);
                
                htmlContent += `
                    <div class="gallery-item" data-index="${globalIndex}">
                        <div class="gallery-card">
                            <div class="gallery-image-container">
                                <img src="${imageUrl}" alt="${escapeHtml(item.title)}" class="gallery-image" loading="lazy" onerror="this.src='/storage/default-menu.jpg'">
                                <div class="category-badge">${getCategoryName(item.category)}</div>
                            </div>
                            <div class="gallery-info">
                                <h3 class="gallery-title">${escapeHtml(item.title)}</h3>
                                <p class="gallery-description">${escapeHtml(item.description || '')}</p>
                            </div>
                        </div>
                    </div>
                `;
            });
        }
        
        container.innerHTML = htmlContent;
        
        // Tambahkan event listener ke setiap gallery item
        document.querySelectorAll('.gallery-item').forEach((item, index) => {
            item.addEventListener('click', () => {
                const globalIndex = parseInt(item.getAttribute('data-index'));
                openLightbox(globalIndex);
            });
        });
        
        renderPagination(filteredItems.length);
    }
    
    function renderPagination(totalItems) {
        const totalPages = Math.ceil(totalItems / itemsPerPage);
        const paginationContainer = document.getElementById('pagination');
        if (!paginationContainer) return;
        if (totalPages <= 1) { 
            paginationContainer.innerHTML = ''; 
            return; 
        }
        
        let html = '<div class="pagination-nav">';
        html += `<button class="page-btn" onclick="changePage(${currentPage - 1})" ${currentPage === 1 ? 'disabled style="opacity:0.5;"' : ''}>&laquo;</button>`;
        for (let i = 1; i <= totalPages; i++) {
            html += `<button class="page-btn ${i === currentPage ? 'active' : ''}" onclick="changePage(${i})">${i}</button>`;
        }
        html += `<button class="page-btn" onclick="changePage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled style="opacity:0.5;"' : ''}>&raquo;</button>`;
        html += '</div>';
        paginationContainer.innerHTML = html;
    }
    
    function changePage(page) {
        const totalItems = filteredItems.length;
        const totalPages = Math.ceil(totalItems / itemsPerPage);
        if (page < 1 || page > totalPages) return;
        currentPage = page;
        renderGallery();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    
    function openLightbox(index) {
        if (!filteredItems[index]) return;
        
        const item = filteredItems[index];
        currentLightboxIndex = index;
        
        const lightboxModal = document.getElementById('lightboxModal');
        const lightboxImage = document.getElementById('lightboxImage');
        const lightboxTitle = document.getElementById('lightboxTitle');
        const lightboxDesc = document.getElementById('lightboxDesc');
        const lightboxCategory = document.getElementById('lightboxCategory');
        
        if (lightboxImage) lightboxImage.src = getImageUrl(item.image);
        if (lightboxTitle) lightboxTitle.textContent = item.title;
        if (lightboxDesc) lightboxDesc.textContent = item.description || '';
        if (lightboxCategory) lightboxCategory.textContent = getCategoryName(item.category);
        
        if (lightboxModal) {
            lightboxModal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
    }
    
    function closeLightbox() {
        const lightboxModal = document.getElementById('lightboxModal');
        if (lightboxModal) {
            lightboxModal.classList.remove('show');
            document.body.style.overflow = 'auto';
        }
    }
    
    function navigateLightbox(direction) {
        if (filteredItems.length === 0) return;
        
        if (direction === 'prev') {
            currentLightboxIndex = (currentLightboxIndex - 1 + filteredItems.length) % filteredItems.length;
        } else {
            currentLightboxIndex = (currentLightboxIndex + 1) % filteredItems.length;
        }
        openLightbox(currentLightboxIndex);
    }
    
    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        renderGallery();
        
        // Filter buttons
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                currentFilter = this.getAttribute('data-filter');
                currentPage = 1;
                renderGallery();
            });
        });
        
        // Lightbox controls
        const closeBtn = document.getElementById('closeLightbox');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const lightboxModal = document.getElementById('lightboxModal');
        
        if (closeBtn) {
            closeBtn.addEventListener('click', closeLightbox);
        }
        
        if (prevBtn) {
            prevBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                navigateLightbox('prev');
            });
        }
        
        if (nextBtn) {
            nextBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                navigateLightbox('next');
            });
        }
        
        if (lightboxModal) {
            lightboxModal.addEventListener('click', function(e) {
                if (e.target === this) closeLightbox();
            });
        }
        
        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (lightboxModal && lightboxModal.classList.contains('show')) {
                if (e.key === 'Escape') {
                    closeLightbox();
                } else if (e.key === 'ArrowLeft') {
                    navigateLightbox('prev');
                } else if (e.key === 'ArrowRight') {
                    navigateLightbox('next');
                }
            }
        });
    });
</script>
@endsection