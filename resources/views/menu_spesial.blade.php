{{-- resources/views/menu_spesial.blade.php --}}
@extends('layouts.app')

@section('title', 'Menu Spesial - Café Kopitiam33')

@push('styles')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    /* Color Variables - SAMA DENGAN MENU */
    :root {
        --sage: #8BA888;
        --cream: #F5EFE6;
        --wood: #A67B5B;
        --accent: #D97642;
        --gold: #D4AF37;
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
    
    /* Menu Header - SAMA DENGAN MENU */
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
    
    /* Featured Section */
    .featured-section {
        padding: 2rem 0 1rem 0;
    }
    
    .featured-card {
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .featured-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
    }
    
    .featured-grid {
        display: grid;
        grid-template-columns: 1fr;
    }
    
    @media (min-width: 768px) {
        .featured-grid {
            grid-template-columns: 1fr 1fr;
        }
    }
    
    .featured-image {
        height: 300px;
        background-size: cover;
        background-position: center;
        position: relative;
    }
    
    .featured-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: var(--gold);
        color: var(--wood);
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 700;
    }
    
    .featured-content {
        padding: 1.5rem;
    }
    
    .featured-category {
        display: inline-block;
        background: rgba(217, 118, 66, 0.1);
        color: var(--accent);
        padding: 0.2rem 0.6rem;
        border-radius: 20px;
        font-size: 0.7rem;
        margin-bottom: 0.75rem;
    }
    
    .featured-title {
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--wood);
        margin-bottom: 0.5rem;
    }
    
    .featured-desc {
        color: #6b7280;
        font-size: 0.85rem;
        line-height: 1.5;
        margin-bottom: 1rem;
    }
    
    .featured-price {
        font-size: 1.25rem;
        font-weight: bold;
        color: var(--accent);
        margin-bottom: 1rem;
    }
    
    /* Section Header */
    .section-header {
        text-align: center;
        margin: 2rem 0 1.5rem 0;
    }
    
    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.75rem;
        font-weight: 600;
        color: var(--wood);
        position: relative;
        display: inline-block;
    }
    
    .section-title::after {
        content: '';
        display: block;
        width: 60px;
        height: 3px;
        background: var(--accent);
        margin: 0.5rem auto 0;
        border-radius: 2px;
    }
    
    /* Menu Grid - SAMA DENGAN MENU */
    .menu-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
        padding: 2rem 0 3rem 0;
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
    
    /* Menu Card - SAMA DENGAN MENU */
    .menu-card {
        background: white;
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .menu-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
    
    /* PERBAIKAN CSS GAMBAR (ASPECT RATIO 16:9) */
    .menu-image-container {
        position: relative;
        aspect-ratio: 16 / 9;
        width: 100%;
        overflow: hidden;
        background-color: #f3f4f6;
    }
    
    .menu-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.5s;
    }
    
    .menu-card:hover .menu-image {
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
    
    .badge-accent {
        background: var(--accent);
        color: white;
    }
    
    .badge-gold {
        background: var(--gold);
        color: var(--wood);
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
    
    /* Button Group - SAMA DENGAN MENU */
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
    
    /* Alert Login - SAMA DENGAN MENU */
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
    
    /* Pagination - SAMA DENGAN MENU */
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 1rem;
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
    
    /* Modal - SAMA DENGAN MENU */
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
    
    .empty-state {
        text-align: center;
        padding: 3rem;
        background: white;
        border-radius: 1rem;
        grid-column: 1/-1;
    }
    
    /* Responsive - SAMA DENGAN MENU */
    @media (max-width: 640px) {
        .menu-header h1 {
            font-size: 1.75rem;
        }
        
        .button-group {
            flex-direction: column;
        }
        
        .featured-image {
            height: 200px;
        }
        
        .featured-title {
            font-size: 1.1rem;
        }
        
        .section-title {
            font-size: 1.5rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Menu Header - SAMA DENGAN MENU -->
<section class="menu-header">
    <div class="container">
        <h1>✨ Menu Spesial</h1>
        <p>Hidangan pilihan dengan bahan terbaik dan resep eksklusif</p>
    </div>
</section>

<!-- Featured Menu - MENU UNGGULAN DI ATAS -->
@if(isset($featuredMenu) && $featuredMenu)
<section class="featured-section">
    <div class="container">
        <div class="featured-card">
            <div class="featured-grid">
                <div class="featured-image" style="background-image: url('{{ $featuredMenu->image_url ?? asset('storage/default-menu.jpg') }}');">
                    <div class="featured-badge">⭐ {{ $featuredMenu->badge ?? 'Signature' }}</div>
                </div>
                <div class="featured-content">
                    <span class="featured-category">👨‍🍳 Chef's Signature</span>
                    <h3 class="featured-title">{{ $featuredMenu->name }}</h3>
                    <p class="featured-desc">{{ $featuredMenu->description ?? 'Nikmati kelezatan menu spesial kami' }}</p>
                    <div class="featured-price">Rp {{ number_format($featuredMenu->price, 0, ',', '.') }}</div>
                    <div class="button-group">
                        @auth
                            <button class="cart-btn" onclick="addToCart({{ $featuredMenu->id }})">🛒 Keranjang</button>
                            <button class="order-btn" onclick="orderNow({{ $featuredMenu->id }})">📝 Pesan</button>
                        @else
                            <button class="cart-btn" onclick="requireLogin()">🛒 Keranjang</button>
                            <button class="order-btn" onclick="requireLogin()">📝 Pesan</button>
                        @endauth
                    </div>
                    @guest
                        <div class="alert-login">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <span>Login untuk membeli</span>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Section Header -->
<div class="container">
    <div class="section-header">
        <h2 class="section-title">🍽️ Koleksi Menu Spesial</h2>
    </div>
</div>

<!-- Menu Grid -->
<section>
    <div class="container">
        <div class="menu-grid" id="menuGrid"></div>
        <div class="pagination" id="pagination"></div>
    </div>
</section>

<!-- Modal - SAMA DENGAN MENU -->
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
    // Data dari database
    const menuSpesialData = @json($menuSpesial ?? []);
    const featuredMenuData = @json($featuredMenu ?? null);
    
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
    
    function getImageUrl(image) {
        if (!image) return '/storage/default-menu.jpg';
        if (image.startsWith('http')) return image;
        if (image.startsWith('/storage/')) return image;
        if (image.startsWith('uploads/')) return '/' + image;
        return '/storage/' + image;
    }
    
    // Ambil semua menu (tanpa featured menu untuk grid)
    function getRegularMenus() {
        let filtered = [...menuSpesialData];
        if (featuredMenuData) {
            filtered = filtered.filter(item => item.id !== featuredMenuData.id);
        }
        return filtered;
    }
    
    // PERBAIKAN: RENDER MENU DISATUKAN MENJADI STRING
    function renderMenu() {
        const regularMenus = getRegularMenus();
        const startIndex = (currentPage - 1) * itemsPerPage;
        const paginatedItems = regularMenus.slice(startIndex, startIndex + itemsPerPage);
        const container = document.getElementById('menuGrid');
        
        if (!container) return;
        
        if (regularMenus.length === 0 && !featuredMenuData) {
            container.innerHTML = `<div class="empty-state"><p>✨ Belum ada menu spesial saat ini</p><p style="font-size: 0.8rem; margin-top: 0.5rem;">Kunjungi lagi nanti untuk menu menarik</p></div>`;
            document.getElementById('pagination').innerHTML = '';
            return;
        }
        
        if (regularMenus.length === 0 && featuredMenuData) {
            container.innerHTML = `<div class="empty-state"><p>✨ Belum ada menu spesial lainnya</p><p style="font-size: 0.8rem; margin-top: 0.5rem;">Kunjungi lagi nanti untuk menu menarik</p></div>`;
            document.getElementById('pagination').innerHTML = '';
            return;
        }
        
        // Wadah HTML kosong
        let htmlContent = '';
        
        paginatedItems.forEach(item => {
            let badgeHtml = '';
            if (item.badge === 'best-seller') {
                badgeHtml = '<span class="badge badge-accent">⭐ BEST SELLER</span>';
            } else if (item.badge === 'new') {
                badgeHtml = '<span class="badge badge-accent badge-right">✨ BARU</span>';
            }
            
            const imageUrl = getImageUrl(item.image);
            
            let buttonHtml = '';
            if (!isLoggedIn) {
                buttonHtml = `
                    <div class="button-group">
                        <button class="cart-btn" onclick="requireLogin()">🛒 Keranjang</button>
                        <button class="order-btn" onclick="requireLogin()">📝 Pesan</button>
                    </div>
                    <div class="alert-login">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <span>Login untuk membeli</span>
                    </div>
                `;
            } else {
                buttonHtml = `
                    <div class="button-group">
                        <button class="cart-btn" onclick="addToCart(${item.id})">🛒 Keranjang</button>
                        <button class="order-btn" onclick="orderNow(${item.id})">📝 Pesan</button>
                    </div>
                `;
            }
            
            htmlContent += `
                <div class="menu-card">
                    <div class="menu-image-container">
                        <img src="${imageUrl}" alt="${item.name}" class="menu-image" onerror="this.src='/storage/default-menu.jpg'">
                        ${badgeHtml}
                    </div>
                    <div class="menu-info">
                        <div class="menu-header-row">
                            <h3 class="menu-title">${item.name}</h3>
                            <span class="menu-price">Rp ${item.price.toLocaleString('id-ID')}</span>
                        </div>
                        <p class="menu-description">${item.description || 'Nikmati kelezatan menu spesial kami'}</p>
                        <div class="menu-footer">
                            <span class="menu-category">Menu Spesial</span>
                        </div>
                        ${buttonHtml}
                    </div>
                </div>
            `;
        });
        
        // Memasukkan HTML ke DOM sekaligus
        container.innerHTML = htmlContent;
        
        renderPagination(regularMenus.length);
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
        const regularMenus = getRegularMenus();
        const totalPages = Math.ceil(regularMenus.length / itemsPerPage);
        if (page < 1 || page > totalPages) return;
        currentPage = page;
        renderMenu();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    
    function addToCart(itemId) {
        const item = menuSpesialData.find(m => m.id === itemId);
        if (!item) return;
        
        const existing = cart.find(c => c.id === itemId);
        if (existing) {
            existing.quantity += 1;
        } else {
            cart.push({ 
                id: item.id, 
                name: item.name, 
                price: item.price, 
                image: item.image, 
                quantity: 1,
                is_menu_spesial: true
            });
        }
        
        localStorage.setItem('kopitiam_cart', JSON.stringify(cart));
        showNotification(`${item.name} ditambahkan ke keranjang! 🛒`);
        window.dispatchEvent(new CustomEvent('cart-updated'));
    }
    
    function orderNow(itemId) {
        const item = menuSpesialData.find(m => m.id === itemId);
        if (!item) return;
        
        selectedItem = item;
        selectedQty = 1;
        document.getElementById('qtyValue').textContent = selectedQty;
        document.getElementById('modalTitle').textContent = selectedItem.name;
        document.getElementById('quantityModal').classList.add('show');
    }
    
    function incrementQty() { 
        selectedQty++; 
        document.getElementById('qtyValue').textContent = selectedQty; 
    }
    
    function decrementQty() { 
        if (selectedQty > 1) { 
            selectedQty--; 
            document.getElementById('qtyValue').textContent = selectedQty; 
        } 
    }
    
    function confirmOrder() {
        if (!selectedItem) {
            showNotification('Error: Tidak ada item yang dipilih');
            closeModal();
            return;
        }
        
        const confirmBtn = document.querySelector('.modal-confirm');
        const originalText = confirmBtn.textContent;
        confirmBtn.textContent = '⏳ Memproses...';
        confirmBtn.disabled = true;
        
        const orderItem = {
            id: selectedItem.id,
            name: selectedItem.name,
            price: parseInt(selectedItem.price),
            quantity: parseInt(selectedQty),
            image: selectedItem.image || '',
            is_menu_spesial: true
        };
        
        fetch('{{ route("order.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ cart: [orderItem] })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('✅ Pesanan berhasil!');
                setTimeout(() => {
                    window.location.href = '{{ route("orders.history") }}';
                }, 1500);
            } else {
                showNotification('❌ Gagal: ' + (data.message || 'Error'));
                confirmBtn.textContent = originalText;
                confirmBtn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('⚠️ Terjadi kesalahan');
            confirmBtn.textContent = originalText;
            confirmBtn.disabled = false;
        });
        
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
    
    const style = document.createElement('style');
    style.textContent = `@keyframes slideIn{from{transform:translateX(100%);opacity:0;}to{transform:translateX(0);opacity:1;}}`;
    document.head.appendChild(style);
    
    // PERBAIKAN: EKSEKUSI LANGSUNG RENDER MENU
    renderMenu();
</script>
@endsection