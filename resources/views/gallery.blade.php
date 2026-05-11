{{-- resources/views/galeri.blade.php --}}
@extends('layouts.app')

@section('title', 'Galeri - Café Kopitiam33')

@push('styles')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    :root {
        --sage: #8BA888;
        --cream: #F5EFE6;
        --wood: #A67B5B;
        --accent: #D97642;
        --gray: #6B7280;
        --white: #FFFFFF;
    }
    
    .container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    
    /* HEADER - SAMA DENGAN HALAMAN LAIN */
    .gallery-header {
        background: var(--sage);
        color: white;
        padding: 3rem 0;
        text-align: center;
    }
    
    .gallery-header h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .gallery-header p {
        font-size: 1rem;
        max-width: 600px;
        margin: 0 auto;
        opacity: 0.9;
    }
    
    /* FILTER SECTION */
    .filter-section {
        background: #F5F1EC;
        padding: 1rem 0;
        position: sticky;
        top: 64px;
        z-index: 40;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    
    .filter-wrapper {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    @media (min-width: 1024px) {
        .filter-wrapper {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    }
    
    .filter-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        justify-content: center;
    }
    
    .filter-btn {
        padding: 0.5rem 1.25rem;
        border-radius: 2rem;
        font-size: 0.875rem;
        font-weight: 500;
        background: #EDE7DF;
        color: var(--wood);
        border: none;
        cursor: pointer;
        transition: all 0.25s ease;
        font-family: 'Poppins', sans-serif;
    }
    
    .filter-btn:hover {
        background: #e2dbd2;
        transform: translateY(-2px);
    }
    
    .filter-btn.active {
        background: var(--sage);
        color: white;
    }
    
    /* GALLERY GRID - RESPONSIVE GRID */
    .gallery-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
        padding: 2rem 0 4rem 0;
    }
    
    @media (min-width: 640px) {
        .gallery-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (min-width: 1024px) {
        .gallery-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    
    @media (min-width: 1280px) {
        .gallery-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }
    
    /* SEMUA CARD MEMILIKI UKURAN YANG SAMA */
    .gallery-item {
        cursor: pointer;
        height: 100%;
    }
    
    .gallery-card {
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid rgba(139, 168, 136, 0.1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .gallery-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(139, 168, 136, 0.2);
    }
    
    /* SEMUA GAMBAR MEMILIKI ASPECT RATIO 16:9 */
    .gallery-image-container {
        position: relative;
        aspect-ratio: 16 / 9;
        width: 100%;
        overflow: hidden;
        background-color: #f3f4f6;
    }
    
    .gallery-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.5s ease;
    }
    
    .gallery-card:hover .gallery-image {
        transform: scale(1.08);
    }
    
    /* BADGE KATEGORI */
    .category-badge {
        position: absolute;
        top: 0.75rem;
        left: 0.75rem;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(4px);
        border-radius: 20px;
        padding: 0.25rem 0.75rem;
        font-size: 0.7rem;
        font-weight: 500;
        color: white;
        z-index: 10;
        letter-spacing: 0.5px;
    }
    
    /* INFO CARD */
    .gallery-info {
        padding: 1rem;
        background: white;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .gallery-title {
        font-weight: 600;
        color: var(--wood);
        font-size: 1rem;
        margin: 0;
        line-height: 1.4;
    }
    
    .gallery-description {
        color: var(--gray);
        font-size: 0.8rem;
        line-height: 1.4;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* LOAD MORE BUTTON */
    .load-more-wrapper {
        text-align: center;
        margin: 0 0 4rem 0;
    }
    
    .load-more-btn {
        background: var(--sage);
        color: white;
        padding: 0.75rem 2rem;
        border: none;
        border-radius: 2rem;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .load-more-btn:hover {
        background: var(--wood);
        transform: translateY(-2px);
    }
    
    /* LIGHTBOX MODAL */
    .lightbox-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.95);
        z-index: 1000;
    }
    
    .lightbox-modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .lightbox-content {
        position: relative;
        max-width: 90%;
        max-height: 85vh;
    }
    
    .lightbox-image {
        width: auto;
        max-width: 100%;
        max-height: 70vh;
        height: auto;
        object-fit: contain;
        border-radius: 0.5rem;
        display: block;
        margin: 0 auto;
    }
    
    .lightbox-caption {
        position: absolute;
        bottom: -60px;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.7);
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        color: white;
        text-align: center;
    }
    
    .lightbox-title {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .lightbox-description {
        font-size: 0.8rem;
        opacity: 0.9;
        margin-bottom: 0.25rem;
    }
    
    .lightbox-category {
        display: inline-block;
        padding: 0.2rem 0.6rem;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        font-size: 0.7rem;
    }
    
    /* NAVIGASI LIGHTBOX */
    .nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.6);
        color: white;
        border: none;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        font-size: 2rem;
        cursor: pointer;
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    
    .nav-btn:hover {
        background: rgba(0, 0, 0, 0.9);
        transform: translateY(-50%) scale(1.1);
    }
    
    .nav-btn.prev {
        left: 30px;
    }
    
    .nav-btn.next {
        right: 30px;
    }
    
    .close-btn {
        position: absolute;
        top: 30px;
        right: 40px;
        background: rgba(0, 0, 0, 0.6);
        color: white;
        border: none;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        font-size: 1.8rem;
        cursor: pointer;
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    
    .close-btn:hover {
        background: rgba(0, 0, 0, 0.9);
        transform: scale(1.1);
    }
    
    /* EMPTY STATE */
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 1rem;
    }
    
    .empty-state svg {
        width: 80px;
        height: 80px;
        color: var(--gray);
        margin-bottom: 1rem;
    }
    
    .empty-state h3 {
        font-size: 1.25rem;
        color: var(--wood);
        margin-bottom: 0.5rem;
    }
    
    .empty-state p {
        color: var(--gray);
        font-size: 0.9rem;
    }
    
    /* RESPONSIVE */
    @media (max-width: 768px) {
        .gallery-header h1 {
            font-size: 1.75rem;
        }
        
        .gallery-header p {
            font-size: 0.875rem;
        }
        
        .gallery-grid {
            gap: 1rem;
            padding: 1.5rem 0 3rem 0;
        }
        
        .filter-btn {
            padding: 0.4rem 1rem;
            font-size: 0.75rem;
        }
        
        .nav-btn {
            width: 35px;
            height: 35px;
            font-size: 1.3rem;
        }
        
        .nav-btn.prev {
            left: 10px;
        }
        
        .nav-btn.next {
            right: 10px;
        }
        
        .close-btn {
            width: 35px;
            height: 35px;
            font-size: 1.3rem;
            top: 15px;
            right: 15px;
        }
    }
    
    @media (max-width: 480px) {
        .gallery-info {
            padding: 0.75rem;
        }
        
        .gallery-title {
            font-size: 0.85rem;
        }
        
        .gallery-description {
            font-size: 0.7rem;
        }
        
        .category-badge {
            font-size: 0.6rem;
            padding: 0.2rem 0.5rem;
        }
    }
</style>
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
        <div class="load-more-wrapper">
            <button id="loadMoreBtn" class="load-more-btn">Muat Lebih Banyak</button>
        </div>
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
    let displayedItems = 12;
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
        
        const itemsToShow = filteredItems.slice(0, displayedItems);
        
        let htmlContent = '';
        
        if (itemsToShow.length === 0) {
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
            itemsToShow.forEach((item, idx) => {
                const imageUrl = getImageUrl(item.image);
                
                htmlContent += `
                    <div class="gallery-item" data-index="${idx}">
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
                openLightbox(index);
            });
        });
        
        const loadMoreBtn = document.getElementById('loadMoreBtn');
        if (loadMoreBtn) {
            loadMoreBtn.style.display = displayedItems < filteredItems.length && filteredItems.length > 0 ? 'flex' : 'none';
        }
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
                displayedItems = 12;
                renderGallery();
            });
        });
        
        // Load more button
        const loadMoreBtn = document.getElementById('loadMoreBtn');
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', function() {
                displayedItems += 8;
                renderGallery();
            });
        }
        
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