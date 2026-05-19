{{-- resources/views/promo.blade.php --}}
@extends('layouts.app')

@section('title', 'Promo Spesial - Café Kopitiam33')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/promo.css') }}">
@endpush

@section('content')
<!-- Promo Header -->
<section class="promo-header">
    <div class="container">
        <h1>🎁 Promo Spesial</h1>
        <p>Nikmati berbagai penawaran menarik dan diskon spesial hanya untuk Anda</p>
    </div>
</section>

<!-- Filter Section -->
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

<!-- Lightbox Promo -->
<div id="promoLightbox" class="promo-lightbox">
    <button class="promo-lightbox-close" id="closePromoLightbox">✕</button>
    <div class="promo-lightbox-content">
        <img id="promoLightboxImage" class="promo-lightbox-image" src="" alt="">
        <div class="promo-lightbox-caption">
            <h3 id="promoLightboxTitle" class="promo-lightbox-title"></h3>
            <p id="promoLightboxPrice" class="promo-lightbox-price"></p>
            <span id="promoLightboxDiscount" class="promo-lightbox-discount"></span>
        </div>
    </div>
</div>

<!-- Quantity Modal -->
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
    const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
    
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
    
    // ==================== LIGHTBOX FUNCTIONS ====================
    function openLightbox(promo) {
        const lightbox = document.getElementById('promoLightbox');
        const lightboxImage = document.getElementById('promoLightboxImage');
        const lightboxTitle = document.getElementById('promoLightboxTitle');
        const lightboxPrice = document.getElementById('promoLightboxPrice');
        const lightboxDiscount = document.getElementById('promoLightboxDiscount');
        
        const originalPrice = promo.original_price || 0;
        const finalPrice = Math.floor(originalPrice - (originalPrice * promo.discount / 100));
        
        if (lightboxImage) lightboxImage.src = getImageUrl(promo.image);
        if (lightboxTitle) lightboxTitle.textContent = promo.name;
        if (lightboxPrice) lightboxPrice.innerHTML = `Rp ${formatPrice(finalPrice)} <span style="text-decoration: line-through; font-size:0.7rem; opacity:0.7;">Rp ${formatPrice(originalPrice)}</span>`;
        if (lightboxDiscount) lightboxDiscount.textContent = `⚡ Diskon ${promo.discount}%`;
        
        if (lightbox) {
            lightbox.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
    }
    
    function closeLightbox() {
        const lightbox = document.getElementById('promoLightbox');
        if (lightbox) {
            lightbox.classList.remove('show');
            document.body.style.overflow = 'auto';
        }
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
        
        let htmlContent = '';
        
        paginatedItems.forEach(promo => {
            const originalPrice = promo.original_price || 0;
            const finalPrice = Math.floor(originalPrice - (originalPrice * promo.discount / 100));
            const imageUrl = getImageUrl(promo.image);
            
            // Data untuk lightbox
            const promoDataLightbox = {
                id: promo.id,
                name: promo.name,
                original_price: originalPrice,
                discount: promo.discount,
                image: promo.image
            };
            const promoJson = JSON.stringify(promoDataLightbox).replace(/"/g, '&quot;');
            
            let buttonHtml = '';
            if (!isLoggedIn) {
                buttonHtml = `
                    <div class="button-group">
                        <button class="cart-btn" onclick="requireLogin()">🛒 Keranjang</button>
                        <button class="order-now-btn" onclick="requireLogin()">📝 Pesan</button>
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
                        <button class="cart-btn" onclick="addToCart(${promo.id}, ${finalPrice}, ${originalPrice}, ${promo.discount})">🛒 Keranjang</button>
                        <button class="order-now-btn" onclick="orderNow(${promo.id}, ${finalPrice}, ${originalPrice}, ${promo.discount})">📝 Pesan</button>
                    </div>
                `;
            }
            
            htmlContent += `
                <div class="promo-card">
                    <div class="promo-badge">⚡ ${promo.discount}% OFF</div>
                    <div class="promo-image-container" onclick='openLightbox(${promoJson})'>
                        <img src="${imageUrl}" alt="${escapeHtml(promo.name)}" class="promo-image" onerror="this.src='/storage/default-menu.jpg'">
                        <div class="zoom-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/>
                            </svg>
                        </div>
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
                        ${buttonHtml}
                    </div>
                </div>
            `;
        });
        
        container.innerHTML = htmlContent;
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
        window.scrollTo({ top: 0, behavior: 'smooth' });
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
    
    // ==================== EVENT LISTENERS ====================
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                currentSearch = e.target.value;
                currentPage = 1;
                renderPromo();
            });
        }
        
        // Lightbox close button
        const closeBtn = document.getElementById('closePromoLightbox');
        const lightboxModal = document.getElementById('promoLightbox');
        
        if (closeBtn) {
            closeBtn.addEventListener('click', closeLightbox);
        }
        
        if (lightboxModal) {
            lightboxModal.addEventListener('click', function(e) {
                if (e.target === this) closeLightbox();
            });
        }
        
        // Keyboard ESC for lightbox
        document.addEventListener('keydown', function(e) {
            if (lightboxModal && lightboxModal.classList.contains('show')) {
                if (e.key === 'Escape') {
                    closeLightbox();
                }
            }
        });
    });
    
    // Panggil langsung agar instan tanpa jeda
    renderPromo();
</script>
@endsection