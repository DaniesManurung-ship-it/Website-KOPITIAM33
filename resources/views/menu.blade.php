{{-- resources/views/menu.blade.php --}}
@extends('layouts.app')

@section('title', 'Menu - Café Kopitiam33')

@push('styles')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    /* Color Variables */
    :root {
        --sage: #8BA888;
        --cream: #F5EFE6;
        --wood: #A67B5B;
        --accent: #D97642;
    }
    
    body {
        font-family: 'Poppins', sans-serif;
        background: #F5EFE6;
    }
    
    /* Container */
    .container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    
    /* Menu Header */
    .menu-header {
        background: var(--sage);
        color: white;
        padding: 3rem 0;
        text-align: center;
    }
    
    .menu-header h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .menu-header p {
        font-size: 1rem;
        max-width: 600px;
        margin: 0 auto;
        opacity: 0.9;
    }
    
    /* Filter Section */
    .filter-section {
        background: white;
        padding: 1.5rem 0;
        position: sticky;
        top: 64px;
        z-index: 40;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }
    
    .filter-wrapper {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    @media (min-width: 768px) {
        .filter-wrapper {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    }
    
    .filter-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        align-items: center;
    }
    
    .filter-btn {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        font-family: 'Poppins', sans-serif;
    }
    
    .filter-btn.bg-sage {
        background: var(--sage);
        color: white;
    }
    
    .filter-btn.bg-cream {
        background: var(--cream);
        color: var(--wood);
    }
    
    .filter-btn.bg-cream:hover {
        background: var(--sage);
        color: white;
    }
    
    .filter-parent {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        font-family: 'Poppins', sans-serif;
        background: var(--cream);
        color: var(--wood);
    }
    
    .filter-parent:hover {
        background: var(--sage);
        color: white;
    }
    
    .dropdown {
        position: relative;
    }
    
    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        margin-top: 0.5rem;
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        width: 128px;
        z-index: 50;
        display: none;
    }
    
    .dropdown-menu.show {
        display: block;
    }
    
    .dropdown-item {
        display: block;
        width: 100%;
        padding: 0.5rem 1rem;
        text-align: left;
        background: none;
        border: none;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        font-size: 0.875rem;
        color: #374151;
    }
    
    .dropdown-item:hover {
        background: var(--sage);
        color: white;
    }
    
    /* Search */
    .search-wrapper {
        position: relative;
    }
    
    .search-input {
        width: 100%;
        padding: 0.5rem 0.75rem 0.5rem 2.5rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        font-family: 'Poppins', sans-serif;
        font-size: 0.875rem;
        outline: none;
    }
    
    .search-input:focus {
        outline: none;
        border-color: var(--sage);
        box-shadow: 0 0 0 2px rgba(139, 168, 136, 0.2);
    }
    
    @media (min-width: 768px) {
        .search-input {
            width: 256px;
        }
    }
    
    .search-icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        color: #9ca3af;
    }
    
    /* Menu Grid */
    .menu-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
        padding: 3rem 0;
    }
    
    @media (min-width: 640px) {
        .menu-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (min-width: 1024px) {
        .menu-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    
    @media (min-width: 1280px) {
        .menu-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }
    
    .menu-item {
        background: white;
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .menu-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
    
    .menu-image-container {
        position: relative;
        height: 160px;
        overflow: hidden;
    }
    
    .menu-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    
    .menu-item:hover .menu-image {
        transform: scale(1.05);
    }
    
    .badge {
        position: absolute;
        top: 0.75rem;
        left: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .badge-red {
        background: #dc2626;
        color: white;
    }
    
    .badge-accent {
        background: var(--accent);
        color: white;
    }
    
    .badge-green {
        background: #16a34a;
        color: white;
    }
    
    .badge-right {
        left: auto;
        right: 0.75rem;
    }
    
    .menu-info {
        padding: 0.75rem;
    }
    
    .menu-header-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.25rem;
    }
    
    .menu-title {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--wood);
    }
    
    .menu-price {
        font-weight: bold;
        color: var(--accent);
        font-size: 0.85rem;
    }
    
    .menu-description {
        color: #6b7280;
        font-size: 0.7rem;
        margin-bottom: 0.5rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .menu-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .menu-category {
        font-size: 0.65rem;
        color: var(--sage);
        font-weight: 500;
    }
    
    /* Button Group - SAMA SEPERTI HALAMAN PROMO */
    .button-group {
        display: flex;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }
    
    .cart-btn {
        flex: 1;
        background: var(--sage);
        color: white;
        padding: 0.35rem 0.5rem;
        border: none;
        border-radius: 0.375rem;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.2s;
        font-family: 'Poppins', sans-serif;
        font-size: 0.65rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.25rem;
    }
    
    .cart-btn:hover {
        background: var(--wood);
    }
    
    .cart-btn svg {
        width: 12px;
        height: 12px;
    }
    
    .cart-btn:disabled {
        background: #e5e7eb;
        color: #6b7280;
        cursor: not-allowed;
    }
    
    .order-btn {
        flex: 1;
        background: var(--accent);
        color: white;
        padding: 0.35rem 0.5rem;
        border: none;
        border-radius: 0.375rem;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.2s;
        font-family: 'Poppins', sans-serif;
        font-size: 0.65rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.25rem;
    }
    
    .order-btn:hover {
        background: #c0392b;
    }
    
    .order-btn svg {
        width: 12px;
        height: 12px;
    }
    
    .order-btn:disabled {
        background: #e5e7eb;
        color: #6b7280;
        cursor: not-allowed;
    }
    
    /* Alert Login - SAMA SEPERTI HALAMAN PROMO */
    .alert-login {
        background: #FEF3C7;
        color: #D97706;
        border-radius: 0.5rem;
        padding: 0.4rem 0.6rem;
        font-size: 0.65rem;
        text-align: center;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
    }
    
    .alert-login svg {
        width: 14px;
        height: 14px;
    }
    
    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
        margin-bottom: 2rem;
    }
    
    .pagination-nav {
        display: flex;
        gap: 0.5rem;
    }
    
    .page-btn {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        background: var(--cream);
        color: var(--wood);
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        font-family: 'Poppins', sans-serif;
        font-size: 1rem;
    }
    
    .page-btn:hover {
        background: var(--sage);
        color: white;
    }
    
    .page-btn.active {
        background: var(--sage);
        color: white;
    }
    
    /* Order Info Section */
    .order-info {
        background: var(--cream);
        padding: 3rem 0;
        text-align: center;
    }
    
    .order-info h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.875rem;
        font-weight: 600;
        color: var(--wood);
        margin-bottom: 1.5rem;
    }
    
    .steps-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
        max-width: 768px;
        margin: 0 auto;
    }
    
    @media (min-width: 768px) {
        .steps-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    
    .step {
        padding: 1.5rem;
    }
    
    .step-icon {
        width: 64px;
        height: 64px;
        background: rgba(139, 168, 136, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }
    
    .step-number {
        font-size: 1.5rem;
        font-weight: bold;
        color: var(--sage);
    }
    
    .step-title {
        font-weight: 600;
        font-size: 1.125rem;
        color: var(--wood);
        margin-bottom: 0.5rem;
    }
    
    .step-text {
        color: #6b7280;
        font-size: 0.875rem;
    }
    
    /* Modal */
    .quantity-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }
    
    .quantity-modal.show {
        display: flex;
    }
    
    .modal-content {
        background: white;
        border-radius: 1rem;
        max-width: 350px;
        width: 90%;
        padding: 1.5rem;
        text-align: center;
    }
    
    .modal-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--wood);
        margin-bottom: 1rem;
    }
    
    .quantity-control {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        margin: 1rem 0;
    }
    
    .qty-btn {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        border: 1px solid var(--sage);
        background: white;
        cursor: pointer;
        font-size: 1.1rem;
        transition: all 0.2s;
    }
    
    .qty-btn:hover {
        background: var(--sage);
        color: white;
    }
    
    .qty-value {
        font-size: 1.25rem;
        font-weight: 600;
        min-width: 40px;
    }
    
    .modal-buttons {
        display: flex;
        gap: 0.75rem;
        margin-top: 1rem;
    }
    
    .modal-confirm {
        flex: 1;
        background: var(--accent);
        color: white;
        padding: 0.6rem;
        border: none;
        border-radius: 0.5rem;
        cursor: pointer;
    }
    
    .modal-cancel {
        flex: 1;
        background: #e5e7eb;
        color: #374151;
        padding: 0.6rem;
        border: none;
        border-radius: 0.5rem;
        cursor: pointer;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem;
        background: white;
        border-radius: 1rem;
        grid-column: 1/-1;
    }
    
    /* Responsive */
    @media (max-width: 640px) {
        .menu-header h1 {
            font-size: 1.75rem;
        }
        
        .filter-buttons {
            justify-content: center;
        }
        
        .order-info h2 {
            font-size: 1.5rem;
        }
        
        .button-group {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
<!-- Menu Header -->
<section class="menu-header">
    <div class="container">
        <h1>Menu Kami</h1>
        <p>Temukan berbagai pilihan makanan dan minuman dengan cita rasa Kopitiam33 yang autentik</p>
    </div>
</section>

<!-- Menu Filter & Search -->
<section class="filter-section">
    <div class="container">
        <div class="filter-wrapper">
            <div class="filter-buttons" id="menuFilters">
                <button onclick="handleFilter(this, 'all')" class="filter-btn bg-sage" style="background: var(--sage); color: white;">Semua</button>
                <button onclick="handleFilter(this, 'makanan')" class="filter-btn bg-cream">Makanan</button>
                <button onclick="handleFilter(this, 'snacks')" class="filter-btn bg-cream">Snacks</button>
                <div class="dropdown">
                    <button onclick="toggleDropdown('drinkDropdown')" data-parent="minuman" class="filter-parent">Minuman ▾</button>
                    <div id="drinkDropdown" class="dropdown-menu">
                        <button onclick="handleVariant(this, 'minuman-hot', 'minuman')" class="dropdown-item">Hot</button>
                        <button onclick="handleVariant(this, 'minuman-cold', 'minuman')" class="dropdown-item">Cold</button>
                    </div>
                </div>
                <div class="dropdown">
                    <button onclick="toggleDropdown('juiceDropdown')" data-parent="jus" class="filter-parent">Jus ▾</button>
                    <div id="juiceDropdown" class="dropdown-menu">
                        <button onclick="handleVariant(this, 'jus-hot', 'jus')" class="dropdown-item">Hot</button>
                        <button onclick="handleVariant(this, 'jus-cold', 'jus')" class="dropdown-item">Cold</button>
                    </div>
                </div>
                <button onclick="handleFilter(this, 'addon')" class="filter-btn bg-cream">Add On</button>
            </div>
            
            <div class="search-wrapper">
                <input type="text" id="searchInput" placeholder="Cari menu..." class="search-input">
                <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </div>
    </div>
</section>

<!-- Menu Grid -->
<section>
    <div class="container">
        <div class="menu-grid" id="menuGrid"></div>
        <div class="pagination" id="pagination"></div>
    </div>
</section>

<!-- Modal -->
<div id="quantityModal" class="quantity-modal">
    <div class="modal-content">
        <h3 class="modal-title" id="modalTitle">Pilih Jumlah Pesanan</h3>
        <div class="quantity-control">
            <button class="qty-btn" onclick="decrementQty()">-</button>
            <span class="qty-value" id="qtyValue">1</span>
            <button class="qty-btn" onclick="incrementQty()">+</button>
        </div>
        <div class="modal-buttons">
            <button class="modal-cancel" onclick="closeModal()">Batal</button>
            <button class="modal-confirm" onclick="confirmOrder()">Pesan Sekarang</button>
        </div>
    </div>
</div>

<script>
    const menuData = @json($menus);
    
    let currentFilter = 'all';
    let currentSearch = '';
    let currentPage = 1;
    const itemsPerPage = 8;
    let cart = JSON.parse(localStorage.getItem('kopitiam_cart')) || [];
    let selectedItem = null;
    let selectedQty = 1;
    
    // Cek apakah user sudah login
    const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
    
    function requireLogin() {
        if (!isLoggedIn) {
            if(confirm('🔒 Anda harus login terlebih dahulu. Buka halaman login?')) {
                window.location.href = '{{ route("login") }}';
            }
            return false;
        }
        return true;
    }
    
    function getCategoryName(category) {
        const categories = {
            'makanan': 'Makanan Berat',
            'snacks': 'Makanan Ringan',
            'minuman-hot': 'Minuman Panas',
            'minuman-cold': 'Minuman Dingin',
            'jus-hot': 'Jus Panas',
            'jus-cold': 'Jus Dingin',
            'addon': 'Add On'
        };
        return categories[category] || category;
    }
    
    function getImageUrl(image) {
        if (!image) return '/storage/default-menu.jpg';
        if (image.startsWith('http')) return image;
        if (image.startsWith('/storage/')) return image;
        if (image.startsWith('uploads/')) return '/' + image;
        return '/storage/' + image;
    }
    
    function getFilteredItems() {
        let filtered = [...menuData];
        if (currentFilter !== 'all') {
            filtered = filtered.filter(item => item.category === currentFilter);
        }
        if (currentSearch) {
            filtered = filtered.filter(item => 
                item.name.toLowerCase().includes(currentSearch.toLowerCase()) ||
                item.description.toLowerCase().includes(currentSearch.toLowerCase())
            );
        }
        return filtered;
    }
    
    function renderMenu() {
        const filteredItems = getFilteredItems();
        const startIndex = (currentPage - 1) * itemsPerPage;
        const paginatedItems = filteredItems.slice(startIndex, startIndex + itemsPerPage);
        const container = document.getElementById('menuGrid');
        
        if (!container) return;
        container.innerHTML = '';
        
        paginatedItems.forEach(item => {
            const menuItem = document.createElement('div');
            menuItem.className = 'menu-item';
            
            let badgeHtml = '';
            if (!item.is_available) {
                badgeHtml = '<span class="badge badge-red">HABIS</span>';
            } else if (item.badge === 'best-seller') {
                badgeHtml = '<span class="badge badge-accent">BEST SELLER</span>';
            } else if (item.badge === 'new') {
                badgeHtml = '<span class="badge badge-green badge-right">BARU</span>';
            }
            
            const isSoldOut = !item.is_available;
            const imageUrl = getImageUrl(item.image);
            
            // Tampilan SAMA SEPERTI HALAMAN PROMO
            let buttonHtml = '';
            if (isSoldOut) {
                buttonHtml = `
                    <div class="button-group">
                        <button class="cart-btn" disabled style="background:#e5e7eb; color:#6b7280;">Stok Habis</button>
                        <button class="order-btn" disabled style="background:#e5e7eb; color:#6b7280;">Stok Habis</button>
                    </div>
                `;
            } else if (!isLoggedIn) {
                // Guest: tombol dengan alert login (SAMA SEPERTI PROMO)
                buttonHtml = `
                    <div class="button-group">
                        <button class="cart-btn" onclick="requireLogin()">
                            🛒 Keranjang
                        </button>
                        <button class="order-btn" onclick="requireLogin()">
                            📝 Pesan
                        </button>
                    </div>
                    <div class="alert-login">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <span>Login untuk membeli</span>
                    </div>
                `;
            } else {
                // User sudah login: tombol normal (SAMA SEPERTI PROMO)
                buttonHtml = `
                    <div class="button-group">
                        <button class="cart-btn" onclick="addToCart(${item.id})">
                            🛒 Keranjang
                        </button>
                        <button class="order-btn" onclick="orderNow(${item.id})">
                            📝 Pesan
                        </button>
                    </div>
                `;
            }
            
            menuItem.innerHTML = `
                <div class="menu-image-container">
                    <img src="${imageUrl}" alt="${item.name}" class="menu-image" loading="lazy" onerror="this.src='/storage/default-menu.jpg'">
                    ${badgeHtml}
                </div>
                <div class="menu-info">
                    <div class="menu-header-row">
                        <h3 class="menu-title">${item.name}</h3>
                        <span class="menu-price">Rp ${item.price.toLocaleString('id-ID')}</span>
                    </div>
                    <p class="menu-description">${item.description}</p>
                    <div class="menu-footer">
                        <span class="menu-category">${getCategoryName(item.category)}</span>
                    </div>
                    ${buttonHtml}
                </div>
            `;
            container.appendChild(menuItem);
        });
        
        renderPagination(filteredItems.length);
    }
    
    function renderPagination(totalItems) {
        const totalPages = Math.ceil(totalItems / itemsPerPage);
        const paginationContainer = document.getElementById('pagination');
        if (!paginationContainer) return;
        if (totalPages <= 1) { paginationContainer.innerHTML = ''; return; }
        
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
        const totalItems = getFilteredItems().length;
        const totalPages = Math.ceil(totalItems / itemsPerPage);
        if (page < 1 || page > totalPages) return;
        currentPage = page;
        renderMenu();
    }
    
    function handleFilter(el, category) {
        document.querySelectorAll('.filter-btn, .filter-parent').forEach(btn => {
            btn.classList.remove('bg-sage');
            btn.classList.add('bg-cream');
            btn.style.background = '';
            btn.style.color = '';
        });
        el.classList.remove('bg-cream');
        el.classList.add('bg-sage');
        el.style.background = 'var(--sage)';
        el.style.color = 'white';
        currentFilter = category;
        currentPage = 1;
        renderMenu();
    }
    
    function handleVariant(el, category, parent) {
        document.querySelectorAll('.filter-btn, .filter-parent').forEach(btn => {
            btn.classList.remove('bg-sage');
            btn.classList.add('bg-cream');
        });
        el.classList.remove('bg-cream');
        el.classList.add('bg-sage');
        const parentBtn = document.querySelector(`.filter-parent[data-parent="${parent}"]`);
        if (parentBtn) {
            parentBtn.classList.remove('bg-cream');
            parentBtn.classList.add('bg-sage');
        }
        currentFilter = category;
        currentPage = 1;
        renderMenu();
        closeAllDropdowns();
    }
    
    function toggleDropdown(id) {
        const dropdown = document.getElementById(id);
        if (dropdown) dropdown.classList.toggle('show');
    }
    
    function closeAllDropdowns() {
        document.getElementById('drinkDropdown')?.classList.remove('show');
        document.getElementById('juiceDropdown')?.classList.remove('show');
    }
    
    // Fungsi untuk user yang sudah login (aksi nyata)
    function addToCart(itemId) {
        const item = menuData.find(m => m.id === itemId);
        if (!item) return;
        const existing = cart.find(c => c.id === itemId);
        if (existing) existing.quantity += 1;
        else cart.push({ id: item.id, name: item.name, price: item.price, image: item.image, quantity: 1 });
        localStorage.setItem('kopitiam_cart', JSON.stringify(cart));
        showNotification(`${item.name} ditambahkan ke keranjang! 🛒`);
        window.dispatchEvent(new CustomEvent('cart-updated'));
    }
    
    function orderNow(itemId) {
        selectedItem = menuData.find(m => m.id === itemId);
        selectedQty = 1;
        document.getElementById('qtyValue').textContent = selectedQty;
        document.getElementById('modalTitle').textContent = selectedItem.name;
        document.getElementById('quantityModal').classList.add('show');
    }
    
    function incrementQty() { selectedQty++; document.getElementById('qtyValue').textContent = selectedQty; }
    function decrementQty() { if (selectedQty > 1) { selectedQty--; document.getElementById('qtyValue').textContent = selectedQty; } }
    
    function confirmOrder() {
        const total = selectedItem.price * selectedQty;
        showNotification(`${selectedItem.name} (${selectedQty} porsi) - Total Rp ${total.toLocaleString('id-ID')} 🎉`);
        closeModal();
    }
    
    function closeModal() {
        document.getElementById('quantityModal').classList.remove('show');
        selectedItem = null;
        selectedQty = 1;
    }
    
    function showNotification(message) {
        const notif = document.createElement('div');
        notif.style.cssText = `position:fixed;bottom:20px;right:20px;background:var(--sage);color:white;padding:10px 18px;border-radius:8px;font-size:13px;z-index:1000;animation:slideIn 0.3s ease;box-shadow:0 4px 12px rgba(0,0,0,0.15);`;
        notif.textContent = message;
        document.body.appendChild(notif);
        setTimeout(() => notif.remove(), 2000);
    }
    
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#menuFilters')) closeAllDropdowns();
    });
    
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                currentSearch = e.target.value;
                currentPage = 1;
                renderMenu();
            });
        }
        renderMenu();
    });
    
    const style = document.createElement('style');
    style.textContent = `@keyframes slideIn{from{transform:translateX(100%);opacity:0;}to{transform:translateX(0);opacity:1;}}`;
    document.head.appendChild(style);
</script>
@endsection