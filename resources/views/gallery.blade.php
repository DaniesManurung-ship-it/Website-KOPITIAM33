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
    }
    
    .container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    
    .gallery-header {
        background: var(--sage);
        color: white;
        padding: 3rem 0;
        text-align: center;
    }
    
    .gallery-header h1 {
        font-family: 'Playfair Display', serif;
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }
    
    .gallery-header p {
        font-size: 1.25rem;
        max-width: 768px;
        margin: 0 auto;
        opacity: 0.9;
    }
    
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
    }
    
    .filter-btn {
        padding: 0.5rem 1rem;
        border-radius: 0.875rem;
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
    }
    
    .filter-btn.active {
        background: var(--sage);
        color: white;
    }
    
    .gallery-grid {
        columns: 1;
        column-gap: 1.5rem;
        padding: 2rem 0;
    }
    
    .gallery-item {
        break-inside: avoid;
        margin-bottom: 1.5rem;
        cursor: pointer;
    }
    
    @media (min-width: 640px) { .gallery-grid { columns: 2; } }
    @media (min-width: 1024px) { .gallery-grid { columns: 3; } }
    @media (min-width: 1280px) { .gallery-grid { columns: 4; } }
    
    .gallery-card {
        background: white;
        border-radius: 0.75rem;
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid rgba(139, 168, 136, 0.1);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }
    
    .gallery-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(139, 168, 136, 0.15);
    }
    
    /* PERBAIKAN CSS GAMBAR GALERI (ASPECT RATIO 16:9) */
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
        transform: scale(1.05);
    }
    
    .category-badge {
        position: absolute;
        top: 1rem;
        left: 1rem;
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 0.25rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 500;
        color: var(--wood);
        z-index: 10;
    }
    
    .gallery-info {
        padding: 1rem;
        background: white;
    }
    
    .gallery-title {
        font-weight: 600;
        color: #8B5A2B;
        margin-bottom: 0.25rem;
        font-size: 1rem;
    }
    
    .gallery-description {
        color: #6B7280;
        font-size: 0.875rem;
        line-height: 1.4;
    }
    
    .load-more-wrapper {
        text-align: center;
        margin-top: 2rem;
        margin-bottom: 2rem;
    }
    
    .load-more-btn {
        background: var(--sage);
        color: white;
        padding: 0.75rem 2rem;
        border: none;
        border-radius: 0.5rem;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        font-size: 1rem;
    }
    
    .load-more-btn:hover {
        background: var(--wood);
    }
    
    .lightbox-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.9);
        z-index: 1000;
    }
    
    .lightbox-modal.show { display: block; }
    .lightbox-content {
        position: relative;
        max-width: 90%;
        max-height: 90vh;
        margin: 5vh auto;
    }
    .lightbox-image { width: 100%; height: auto; border-radius: 0.5rem; }
    .lightbox-caption {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
        padding: 2rem 1.5rem 1.5rem;
        border-radius: 0 0 0.5rem 0.5rem;
        color: white;
    }
    .lightbox-title { font-size: 1.25rem; font-weight: 600; margin-bottom: 0.25rem; }
    .lightbox-description { font-size: 0.875rem; opacity: 0.9; margin-bottom: 0.5rem; }
    .lightbox-category {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        background: rgba(255,255,255,0.2);
        border-radius: 20px;
        font-size: 0.75rem;
    }
    
    .nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0,0,0,0.5);
        color: white;
        border: none;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        font-size: 2rem;
        cursor: pointer;
        z-index: 10;
    }
    .nav-btn:hover { background: rgba(0,0,0,0.8); }
    .nav-btn.prev { left: 20px; }
    .nav-btn.next { right: 20px; }
    .close-btn {
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(0,0,0,0.5);
        color: white;
        border: none;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        font-size: 2rem;
        cursor: pointer;
        z-index: 10;
    }
    
    .instagram-section {
        background: var(--cream);
        padding: 4rem 0;
    }
    .instagram-header { text-align: center; margin-bottom: 3rem; }
    .instagram-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, #f58529, #dd2a7b, #8134af);
        border-radius: 50%;
        margin-bottom: 1rem;
    }
    .instagram-icon svg { width: 32px; height: 32px; color: white; }
    .instagram-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.25rem;
        font-weight: 600;
        color: var(--wood);
        margin-bottom: 1rem;
    }
    .instagram-subtitle { color: #6b7280; max-width: 672px; margin: 0 auto 2rem; }
    .instagram-link {
        display: inline-flex;
        align-items: center;
        background: linear-gradient(135deg, #f58529, #dd2a7b, #8134af);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        text-decoration: none;
    }
    .instagram-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-top: 2rem;
    }
    @media (min-width: 768px) { .instagram-grid { grid-template-columns: repeat(4, 1fr); } }
    .instagram-item {
        position: relative;
        overflow: hidden;
        border-radius: 0.75rem;
        aspect-ratio: 1;
        text-decoration: none;
    }
    .instagram-image { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
    .instagram-item:hover .instagram-image { transform: scale(1.1); }
    .instagram-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .instagram-item:hover .instagram-overlay { opacity: 1; }
    .instagram-overlay svg { width: 32px; height: 32px; color: white; }
    
    .section { padding: 3rem 0; }
    
    @media (max-width: 640px) {
        .gallery-header h1 { font-size: 2rem; }
        .gallery-header p { font-size: 1rem; }
        .instagram-title { font-size: 1.75rem; }
    }
</style>
@endpush

@section('content')
<section class="gallery-header">
    <div class="container">
        <h1>Galeri Kami</h1>
        <p>Jelajahi momen terbaik, hidangan istimewa, dan suasana hangat Café Kopitiam33</p>
    </div>
</section>

<section class="filter-section">
    <div class="container">
        <div class="filter-wrapper">
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">Semua</button>
                <button class="filter-btn" data-filter="interior">Interior</button>
                <button class="filter-btn" data-filter="food">Makanan</button>
                <button class="filter-btn" data-filter="drink">Minuman</button>
                <button class="filter-btn" data-filter="event">Acara</button>
                <button class="filter-btn" data-filter="chef">Chef</button>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="gallery-grid" id="galleryContainer"></div>
        <div class="load-more-wrapper">
            <button id="loadMoreBtn" class="load-more-btn">Muat Lebih Banyak</button>
        </div>
    </div>
</section>

<div id="lightboxModal" class="lightbox-modal">
    <button class="close-btn" id="closeLightbox">&times;</button>
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

<section class="instagram-section">
    <div class="container">
        <div class="instagram-header">
            <div class="instagram-icon">
                <svg fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069z"/>
                </svg>
            </div>
            <h2 class="instagram-title">Ikuti Perjalanan Kami</h2>
            <p class="instagram-subtitle">Ikuti update terbaru, menu spesial, dan momen-momen spesial di balik layar</p>
            <a href="https://www.instagram.com/kopitiam33_balige/" target="_blank" class="instagram-link">
                @kopitiam33_balige
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </a>
        </div>
        <div class="instagram-grid" id="instagramGrid"></div>
    </div>
</section>

<script>
    // Data dari database
    const galleryItems = @json($galleries);
    
    const instagramFeed = [

    ];
    
    let currentFilter = 'all';
    let displayedItems = 12;
    let currentLightboxIndex = 0;
    let filteredItems = [...galleryItems];
    
    function getCategoryName(category) {
        const categories = {
            'interior': 'Interior',
            'food': 'Makanan',
            'drink': 'Minuman',
            'event': 'Acara',
            'chef': 'Chef'
        };
        return categories[category] || 'Lainnya';
    }
    
    // PERBAIKAN: RENDER GALLERY DISATUKAN MENJADI STRING & HAPUS LAZY
    function renderGallery() {
        const container = document.getElementById('galleryContainer');
        if (!container) return;
        
        filteredItems = galleryItems.filter(item => 
            currentFilter === 'all' || item.category === currentFilter
        );
        
        const itemsToShow = filteredItems.slice(0, displayedItems);
        
        // Wadah HTML kosong
        let htmlContent = '';
        
        itemsToShow.forEach((item, index) => {
            htmlContent += `
                <div class="gallery-item" onclick="openLightbox(${index})">
                    <div class="gallery-card">
                        <div class="gallery-image-container">
                            <img src="${item.image}" alt="${item.title}" class="gallery-image" onerror="this.src='/storage/default-menu.jpg'">
                            <div class="category-badge">${getCategoryName(item.category)}</div>
                        </div>
                        <div class="gallery-info">
                            <h3 class="gallery-title">${item.title}</h3>
                            <p class="gallery-description">${item.description || ''}</p>
                        </div>
                    </div>
                </div>
            `;
        });
        
        // Masukkan ke DOM sekaligus
        container.innerHTML = htmlContent;
        
        const loadMoreBtn = document.getElementById('loadMoreBtn');
        if (loadMoreBtn) {
            loadMoreBtn.style.display = displayedItems < filteredItems.length ? 'block' : 'none';
        }
    }
    
    // PERBAIKAN: RENDER INSTAGRAM DISATUKAN MENJADI STRING & HAPUS LAZY
    function renderInstagram() {
        const container = document.getElementById('instagramGrid');
        if (!container) return;
        
        let htmlContent = '';
        
        instagramFeed.forEach((image, index) => {
            htmlContent += `
                <a href="#" class="instagram-item">
                    <img src="${image}" alt="Instagram ${index + 1}" class="instagram-image" onerror="this.src='/storage/default-menu.jpg'">
                    <div class="instagram-overlay">
                        <svg fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069z"/>
                        </svg>
                    </div>
                </a>
            `;
        });
        
        // Masukkan ke DOM sekaligus
        container.innerHTML = htmlContent;
    }
    
    function openLightbox(index) {
        const item = filteredItems[index];
        currentLightboxIndex = index;
        document.getElementById('lightboxImage').src = item.image;
        document.getElementById('lightboxTitle').textContent = item.title;
        document.getElementById('lightboxDesc').textContent = item.description || '';
        document.getElementById('lightboxCategory').textContent = getCategoryName(item.category);
        document.getElementById('lightboxModal').classList.add('show');
        document.body.style.overflow = 'hidden';
    }
    
    function closeLightbox() {
        document.getElementById('lightboxModal').classList.remove('show');
        document.body.style.overflow = 'auto';
    }
    
    function navigateLightbox(direction) {
        if (direction === 'prev') {
            currentLightboxIndex = (currentLightboxIndex - 1 + filteredItems.length) % filteredItems.length;
        } else {
            currentLightboxIndex = (currentLightboxIndex + 1) % filteredItems.length;
        }
        openLightbox(currentLightboxIndex);
    }
    
    // PERBAIKAN: EKSEKUSI LANGSUNG FUNGSI RENDER DI LUAR EVENT LISTENER
    renderGallery();
    renderInstagram();
    
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                currentFilter = this.getAttribute('data-filter');
                displayedItems = 12;
                renderGallery();
            });
        });
        
        document.getElementById('loadMoreBtn')?.addEventListener('click', function() {
            displayedItems += 8;
            renderGallery();
        });
        
        document.getElementById('closeLightbox')?.addEventListener('click', closeLightbox);
        document.getElementById('prevBtn')?.addEventListener('click', () => navigateLightbox('prev'));
        document.getElementById('nextBtn')?.addEventListener('click', () => navigateLightbox('next'));
        
        document.getElementById('lightboxModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeLightbox();
        });
        
        document.addEventListener('keydown', function(e) {
            if (document.getElementById('lightboxModal').classList.contains('show')) {
                if (e.key === 'Escape') closeLightbox();
                else if (e.key === 'ArrowLeft') navigateLightbox('prev');
                else if (e.key === 'ArrowRight') navigateLightbox('next');
            }
        });
    });
</script>
@endsection