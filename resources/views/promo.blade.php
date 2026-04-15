{{-- resources/views/promo.blade.php --}}
@extends('layouts.app')

@section('title', 'Promo Spesial - Café Kopitiam33')

@push('styles')
<style>
    /* Color Variables - SAME AS MENU */
    :root {
        --sage: #8BA888;
        --cream: #F5EFE6;
        --wood: #A67B5B;
        --accent: #D97642;
    }
    
    /* Promo Header - SAME AS MENU HEADER */
    .promo-header {
        background: var(--sage);
        color: white;
        padding: 3rem 0;
        text-align: center;
    }
    
    .promo-header h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-align: center;
    }
    
    .promo-header p {
        font-size: 1rem;
        max-width: 600px;
        margin: 0 auto;
        opacity: 0.9;
        text-align: center;
    }
    
    /* Filter Section - SAME AS MENU */
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
    
    /* Search - SAME AS MENU */
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
    
    /* Promo Grid - SAME AS MENU GRID */
    .promo-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
        padding: 3rem 0;
    }
    
    @media (min-width: 640px) {
        .promo-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (min-width: 1024px) {
        .promo-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    
    @media (min-width: 1280px) {
        .promo-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }
    
    /* Promo Card - SAME AS MENU CARD */
    .promo-card {
        background: white;
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        transition: transform 0.2s, box-shadow 0.2s;
        position: relative;
    }
    
    .promo-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
    
    .promo-badge {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        background: #ef4444;
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.7rem;
        font-weight: 600;
        z-index: 10;
    }
    
    .promo-image-container {
        position: relative;
        height: 160px;
        overflow: hidden;
    }
    
    .promo-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    
    .promo-card:hover .promo-image {
        transform: scale(1.05);
    }
    
    .promo-content {
        padding: 0.75rem;
    }
    
    .promo-title {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--wood);
        margin-bottom: 0.25rem;
    }
    
    .promo-description {
        color: #6b7280;
        font-size: 0.7rem;
        margin-bottom: 0.5rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Price Section - SAME AS MENU */
    .price-section {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
        flex-wrap: wrap;
    }
    
    .old-price {
        color: #9ca3af;
        font-size: 0.7rem;
        text-decoration: line-through;
    }
    
    .new-price {
        color: var(--accent);
        font-weight: bold;
        font-size: 0.85rem;
    }
    
    .discount-text {
        display: inline-block;
        background: #ef4444;
        color: white;
        padding: 0.2rem 0.4rem;
        border-radius: 0.25rem;
        font-size: 0.65rem;
        font-weight: 600;
    }
    
    /* Period */
    .promo-period {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        margin-bottom: 0.5rem;
        padding: 0.25rem 0;
        border-top: 1px solid #f3f4f6;
        border-bottom: 1px solid #f3f4f6;
        font-size: 0.65rem;
        color: #6b7280;
    }
    
    .promo-period svg {
        width: 12px;
        height: 12px;
        color: var(--sage);
    }
    
    /* Button Group - SAME AS MENU */
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
    
    .order-now-btn {
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
    
    .order-now-btn:hover {
        background: #c0392b;
    }
    
    .order-now-btn svg {
        width: 12px;
        height: 12px;
    }
    
    /* Pagination - SAME AS MENU */
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
    
    /* Info Promo */
    .info-promo {
        background: var(--cream);
        padding: 3rem 0;
        text-align: center;
    }
    
    .info-promo h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.875rem;
        font-weight: 600;
        color: var(--wood);
        margin-bottom: 1.5rem;
    }
    
    .info-list {
        list-style: none;
        padding: 0;
        max-width: 896px;
        margin: 0 auto;
    }
    
    .info-list li {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
        color: #6b7280;
        font-size: 0.875rem;
    }
    
    .info-list li span {
        width: 6px;
        height: 6px;
        background: var(--sage);
        border-radius: 50%;
    }
    
    /* Modal - SAME AS MENU */
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
        .promo-header h1 {
            font-size: 1.75rem;
        }
        
        .filter-buttons {
            justify-content: center;
        }
        
        .button-group {
            flex-direction: column;
        }
        
        .price-section {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endpush

@section('content')
<!-- Promo Header - SAME STYLE AS MENU HEADER -->
<section class="promo-header">
    <div class="container">
        <h1>🎁 Promo Spesial</h1>
        <p>Nikmati berbagai penawaran menarik dan diskon spesial hanya untuk Anda</p>
    </div>
</section>

<!-- Filter Section - SAME AS MENU -->
<section class="filter-section">
    <div class="container">
        <div class="filter-wrapper">
            <div class="filter-buttons" id="promoFilters">
                <button onclick="handleFilter(this, 'all')" class="filter-btn bg-sage">Semua</button>
            </div>
            
            <div class="search-wrapper">
                <input type="text" id="searchInput" placeholder="Cari promo..." class="search-input">
                <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </div>
    </div>
</section>

<!-- Promo Grid -->
<section>
    <div class="container">
        <div class="promo-grid" id="promoGrid"></div>
        <div class="pagination" id="pagination"></div>
    </div>
</section>

<!-- Info Promo -->
<section class="info-promo">
    <div class="container">
        <h2>📋 Syarat & Ketentuan</h2>
        <ul class="info-list">
            <li><span></span> Promo berlaku selama periode yang telah ditentukan</li>
            <li><span></span> Tidak dapat digabungkan dengan promo lainnya</li>
            <li><span></span> Berlaku untuk pembelian di tempat (dine in) dan take away</li>
            <li><span></span> Stok terbatas, first come first served</li>
            <li><span></span> Keputusan pihak café bersifat mutlak</li>
        </ul>
    </div>
</section>

<!-- Quantity Modal - SAME AS MENU -->
<div id="quantityModal" class="quantity-modal">
    <div class="modal-content">
        <h3 class="modal-title" id="modalTitle">Pilih Jumlah Pesanan</h3>
        <div class="quantity-control">
            <button class="qty-btn" onclick="decrementQuantity()">-</button>
            <span class="qty-value" id="quantityValue">1</span>
            <button class="qty-btn" onclick="incrementQuantity()">+</button>
        </div>
        <div class="modal-buttons">
            <button class="modal-cancel" onclick="closeQuantityModal()">Batal</button>
            <button class="modal-confirm" onclick="confirmOrder()">Pesan Sekarang</button>
        </div>
    </div>
</div>

<script>
    const promoData = @json($promos);
    
    let currentSearch = '';
    let currentPage = 1;
    const itemsPerPage = 8;
    let cart = JSON.parse(localStorage.getItem('kopitiam_cart')) || [];
    let selectedPromo = null;
    let selectedQuantity = 1;
    
    function formatDate(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID');
    }
    
    function formatPrice(price) {
        return new Intl.NumberFormat('id-ID').format(price);
    }
    
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    function getFilteredItems() {
        let filtered = [...promoData];
        if (currentSearch) {
            filtered = filtered.filter(item => 
                item.name.toLowerCase().includes(currentSearch.toLowerCase()) ||
                (item.description && item.description.toLowerCase().includes(currentSearch.toLowerCase()))
            );
        }
        return filtered;
    }
    
    function renderPromo() {
        const filteredItems = getFilteredItems();
        const container = document.getElementById('promoGrid');
        
        if (!container) return;
        
        if (filteredItems.length === 0) {
            container.innerHTML = `<div class="empty-state"><p>🎁 Belum ada promo saat ini</p><p style="font-size: 0.8rem; margin-top: 0.5rem;">Kunjungi lagi nanti untuk promo menarik</p></div>`;
            document.getElementById('pagination').innerHTML = '';
            return;
        }
        
        const startIndex = (currentPage - 1) * itemsPerPage;
        const paginatedItems = filteredItems.slice(startIndex, startIndex + itemsPerPage);
        
        container.innerHTML = '';
        
        paginatedItems.forEach(promo => {
            const originalPrice = promo.original_price || 0;
            const finalPrice = Math.floor(originalPrice - (originalPrice * promo.discount / 100));
            
            const card = document.createElement('div');
            card.className = 'promo-card';
            card.innerHTML = `
                <div class="promo-badge">⚡ ${promo.discount}% OFF</div>
                <div class="promo-image-container">
                    <img src="${promo.image}" alt="${promo.name}" class="promo-image" loading="lazy" onerror="this.src='/storage/default-menu.jpg'">
                </div>
                <div class="promo-content">
                    <h3 class="promo-title">${escapeHtml(promo.name)}</h3>
                    <p class="promo-description">${escapeHtml(promo.description || 'Nikmati promo menarik ini')}</p>
                    <div class="price-section">
                        <span class="old-price">Rp ${formatPrice(originalPrice)}</span>
                        <span class="new-price">Rp ${formatPrice(finalPrice)}</span>
                        <span class="discount-text">-${promo.discount}%</span>
                    </div>
                    <div class="promo-period">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>${formatDate(promo.start_date)} - ${formatDate(promo.end_date)}</span>
                    </div>
                    <div class="button-group">
                        <button class="cart-btn" onclick="addToCart(${promo.id}, ${finalPrice}, ${originalPrice}, ${promo.discount})">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Keranjang
                        </button>
                        <button class="order-now-btn" onclick="orderNow(${promo.id}, ${finalPrice}, ${originalPrice}, ${promo.discount})">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                            </svg>
                            Pesan
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(card);
        });
        
        renderPagination(filteredItems.length);
    }
    
    function renderPagination(totalItems) {
        const totalPages = Math.ceil(totalItems / itemsPerPage);
        const container = document.getElementById('pagination');
        if (!container) return;
        if (totalPages <= 1) { container.innerHTML = ''; return; }
        
        let html = '<div class="pagination-nav">';
        html += `<button class="page-btn" onclick="changePage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>&laquo;</button>`;
        for (let i = 1; i <= totalPages; i++) {
            html += `<button class="page-btn ${i === currentPage ? 'active' : ''}" onclick="changePage(${i})">${i}</button>`;
        }
        html += `<button class="page-btn" onclick="changePage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}>&raquo;</button>`;
        html += '</div>';
        container.innerHTML = html;
    }
    
    function changePage(page) {
        const totalItems = getFilteredItems().length;
        const totalPages = Math.ceil(totalItems / itemsPerPage);
        if (page < 1 || page > totalPages) return;
        currentPage = page;
        renderPromo();
    }
    
    function handleFilter(btn, category) {
        document.querySelectorAll('.filter-btn').forEach(b => {
            b.classList.remove('bg-sage');
            b.classList.add('bg-cream');
        });
        btn.classList.remove('bg-cream');
        btn.classList.add('bg-sage');
        currentPage = 1;
        renderPromo();
    }
    
    function addToCart(promoId, price, originalPrice, discount) {
        const promo = promoData.find(p => p.id === promoId);
        if (!promo) return;
        
        const existing = cart.find(item => item.id === promoId && item.is_promo);
        if (existing) {
            existing.quantity += 1;
        } else {
            cart.push({
                id: promo.id,
                name: promo.name,
                price: price,
                original_price: originalPrice,
                discount: discount,
                image: promo.image,
                quantity: 1,
                is_promo: true
            });
        }
        
        localStorage.setItem('kopitiam_cart', JSON.stringify(cart));
        showNotification(`${promo.name} ditambahkan ke keranjang! 🛒`);
        window.dispatchEvent(new CustomEvent('cart-updated'));
    }
    
    function orderNow(promoId, price, originalPrice, discount) {
        const promo = promoData.find(p => p.id === promoId);
        if (!promo) {
            showNotification('Error: Promo tidak ditemukan');
            return;
        }
        
        selectedPromo = {
            id: promo.id,
            name: promo.name,
            finalPrice: price,
            originalPrice: originalPrice,
            discountValue: discount,
            image: promo.image
        };
        selectedQuantity = 1;
        document.getElementById('quantityValue').textContent = selectedQuantity;
        document.getElementById('modalTitle').textContent = promo.name;
        document.getElementById('quantityModal').classList.add('show');
    }
    
    function incrementQuantity() {
        selectedQuantity++;
        document.getElementById('quantityValue').textContent = selectedQuantity;
    }
    
    function decrementQuantity() {
        if (selectedQuantity > 1) {
            selectedQuantity--;
            document.getElementById('quantityValue').textContent = selectedQuantity;
        }
    }
    
    function confirmOrder() {
        if (!selectedPromo) {
            closeQuantityModal();
            return;
        }
        
        const confirmBtn = document.querySelector('.modal-confirm');
        const originalText = confirmBtn.textContent;
        confirmBtn.textContent = '⏳ Memproses...';
        confirmBtn.disabled = true;
        
        const orderItem = {
            id: selectedPromo.id,
            name: selectedPromo.name,
            price: parseInt(selectedPromo.finalPrice),
            original_price: parseInt(selectedPromo.originalPrice),
            discount: parseInt(selectedPromo.discountValue),
            quantity: parseInt(selectedQuantity),
            image: selectedPromo.image || '',
            is_promo: true
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
            showNotification('⚠️ Terjadi kesalahan');
            confirmBtn.textContent = originalText;
            confirmBtn.disabled = false;
        });
        
        closeQuantityModal();
    }
    
    function closeQuantityModal() {
        document.getElementById('quantityModal').classList.remove('show');
        selectedPromo = null;
        selectedQuantity = 1;
    }
    
    function showNotification(message) {
        const notif = document.createElement('div');
        notif.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--sage);
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 13px;
            z-index: 1000;
            animation: slideIn 0.2s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        `;
        notif.textContent = message;
        document.body.appendChild(notif);
        setTimeout(() => notif.remove(), 2000);
    }
    
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    `;
    document.head.appendChild(style);
    
    document.addEventListener('DOMContentLoaded', () => {
        renderPromo();
        
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                currentSearch = e.target.value;
                currentPage = 1;
                renderPromo();
            });
        }
    });
</script>
@endsection