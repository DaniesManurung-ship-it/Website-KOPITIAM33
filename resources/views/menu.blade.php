{{-- resources/views/menu.blade.php --}}
@extends('layouts.app')

@section('title', 'Menu - Café Kopitiam33')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/menu.css') }}">
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
                <div class="dropdown" data-dropdown="drink">
                    <button onclick="toggleDropdown('drinkDropdown')" data-parent="minuman" id="drinkParentBtn" class="filter-parent">Minuman ▾</button>
                    <div id="drinkDropdown" class="dropdown-menu">
                        <button onclick="handleVariant(this, 'minuman-hot', 'minuman')" class="dropdown-item" data-category="minuman-hot">Hot</button>
                        <button onclick="handleVariant(this, 'minuman-cold', 'minuman')" class="dropdown-item" data-category="minuman-cold">Cold</button>
                    </div>
                </div>
                <div class="dropdown" data-dropdown="juice">
                    <button onclick="toggleDropdown('juiceDropdown')" data-parent="jus" id="juiceParentBtn" class="filter-parent">Jus ▾</button>
                    <div id="juiceDropdown" class="dropdown-menu">
                        <button onclick="handleVariant(this, 'jus-hot', 'jus')" class="dropdown-item" data-category="jus-hot">Hot</button>
                        <button onclick="handleVariant(this, 'jus-cold', 'jus')" class="dropdown-item" data-category="jus-cold">Cold</button>
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

<!-- Lightbox Menu -->
<div id="menuLightbox" class="menu-lightbox">
    <button class="menu-lightbox-close" id="closeMenuLightbox">✕</button>
    <div class="menu-lightbox-content">
        <img id="menuLightboxImage" class="menu-lightbox-image" src="" alt="">
        <div class="menu-lightbox-caption">
            <h3 id="menuLightboxTitle" class="menu-lightbox-title"></h3>
            <p id="menuLightboxPrice" class="menu-lightbox-price"></p>
            <span id="menuLightboxCategory" class="menu-lightbox-category"></span>
        </div>
    </div>
</div>

<!-- Modal Quantity -->
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
    
    const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
    
    // Format harga tanpa .00
    function formatPrice(price) {
        return new Intl.NumberFormat('id-ID').format(price);
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
                (item.description && item.description.toLowerCase().includes(currentSearch.toLowerCase()))
            );
        }
        return filtered;
    }
    
    // ==================== LIGHTBOX FUNCTIONS ====================
    function openLightbox(item) {
        const lightbox = document.getElementById('menuLightbox');
        const lightboxImage = document.getElementById('menuLightboxImage');
        const lightboxTitle = document.getElementById('menuLightboxTitle');
        const lightboxPrice = document.getElementById('menuLightboxPrice');
        const lightboxCategory = document.getElementById('menuLightboxCategory');
        
        if (lightboxImage) lightboxImage.src = getImageUrl(item.image);
        if (lightboxTitle) lightboxTitle.textContent = item.name;
        if (lightboxPrice) lightboxPrice.textContent = `Rp ${formatPrice(item.price)}`;
        if (lightboxCategory) lightboxCategory.textContent = getCategoryName(item.category);
        
        if (lightbox) {
            lightbox.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
    }
    
    function closeLightbox() {
        const lightbox = document.getElementById('menuLightbox');
        if (lightbox) {
            lightbox.classList.remove('show');
            document.body.style.overflow = 'auto';
        }
    }
    
    // ==================== FILTER FUNCTIONS ====================
    function resetAllButtons() {
        document.querySelectorAll('.filter-btn, .filter-parent, .dropdown-item').forEach(btn => {
            btn.classList.remove('bg-sage', 'active');
            btn.classList.add('bg-cream');
            btn.style.background = '';
            btn.style.color = '';
        });
    }
    
    function setActiveButton(element) {
        if (element) {
            element.classList.remove('bg-cream', 'active');
            element.classList.add('bg-sage', 'active');
            element.style.background = 'var(--sage)';
            element.style.color = 'white';
        }
    }
    
    function handleFilter(el, category) {
        resetAllButtons();
        setActiveButton(el);
        currentFilter = category;
        currentPage = 1;
        renderMenu();
        closeAllDropdowns();
    }
    
    function handleVariant(el, category, parent) {
        resetAllButtons();
        setActiveButton(el);
        
        let parentBtn = null;
        if (parent === 'minuman') {
            parentBtn = document.getElementById('drinkParentBtn');
        } else if (parent === 'jus') {
            parentBtn = document.getElementById('juiceParentBtn');
        }
        
        if (parentBtn) {
            setActiveButton(parentBtn);
        }
        
        currentFilter = category;
        currentPage = 1;
        renderMenu();
        closeAllDropdowns();
    }
    
    function toggleDropdown(id) {
        const dropdown = document.getElementById(id);
        if (dropdown) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                if (menu.id !== id) {
                    menu.classList.remove('show');
                }
            });
            dropdown.classList.toggle('show');
        }
    }
    
    function closeAllDropdowns() {
        const drinkDropdown = document.getElementById('drinkDropdown');
        const juiceDropdown = document.getElementById('juiceDropdown');
        if (drinkDropdown) drinkDropdown.classList.remove('show');
        if (juiceDropdown) juiceDropdown.classList.remove('show');
    }
    
    // ==================== CART FUNCTIONS ====================
    function addToCart(itemId) {
        if (!requireLogin()) return;
        
        const item = menuData.find(m => m.id === itemId);
        if (!item) return;
        
        // Kirim ke server untuk disimpan di session per user
        fetch('{{ route("cart.add") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                item_id: item.id,
                item_type: 'menu',
                name: item.name,
                price: parseInt(item.price),
                quantity: 1,
                image: item.image,
                is_promo: false,
                is_menu_spesial: false
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(`${item.name} ditambahkan ke keranjang! 🛒`);
                // Update local cart array dengan response dari server
                if (data.cart) {
                    cart = data.cart;
                }
                window.dispatchEvent(new CustomEvent('cart-updated'));
            } else {
                showNotification('Gagal menambahkan ke keranjang', true);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan', true);
        });
    }
    
    function orderNow(itemId) {
        if (!requireLogin()) return;
        
        selectedItem = menuData.find(m => m.id === itemId);
        if (selectedItem) {
            selectedQty = 1;
            document.getElementById('qtyValue').textContent = selectedQty;
            document.getElementById('modalTitle').textContent = selectedItem.name;
            document.getElementById('quantityModal').classList.add('show');
        }
    }
    
    function incrementQty() { 
        selectedQty++; 
        const qtySpan = document.getElementById('qtyValue');
        if (qtySpan) qtySpan.textContent = selectedQty; 
    }
    
    function decrementQty() { 
        if (selectedQty > 1) { 
            selectedQty--; 
            const qtySpan = document.getElementById('qtyValue');
            if (qtySpan) qtySpan.textContent = selectedQty; 
        } 
    }
    
    function confirmOrder() {
        if (!selectedItem) {
            closeModal();
            return;
        }
        
        const confirmBtn = document.querySelector('.modal-confirm');
        const originalText = confirmBtn ? confirmBtn.textContent : 'Confirm';
        if (confirmBtn) {
            confirmBtn.textContent = '⏳ Memproses...';
            confirmBtn.disabled = true;
        }
        
        const orderItem = {
            id: selectedItem.id,
            name: selectedItem.name,
            price: parseInt(selectedItem.price),
            quantity: parseInt(selectedQty),
            image: selectedItem.image || '',
            is_promo: false
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
                if (confirmBtn) {
                    confirmBtn.textContent = originalText;
                    confirmBtn.disabled = false;
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('⚠️ Terjadi kesalahan');
            if (confirmBtn) {
                confirmBtn.textContent = originalText;
                confirmBtn.disabled = false;
            }
        });
        
        closeModal();
    }
    
    function closeModal() {
        const modal = document.getElementById('quantityModal');
        if (modal) modal.classList.remove('show');
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
    
    // ==================== RENDER FUNCTIONS ====================
    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }
    
    function renderMenu() {
        const filteredItems = getFilteredItems();
        const startIndex = (currentPage - 1) * itemsPerPage;
        const paginatedItems = filteredItems.slice(startIndex, startIndex + itemsPerPage);
        const container = document.getElementById('menuGrid');
        
        if (!container) return;
        
        let htmlContent = '';
        
        if (paginatedItems.length === 0) {
            htmlContent = '<div class="empty-state"><p>Tidak ada menu yang ditemukan</p></div>';
        } else {
            paginatedItems.forEach(item => {
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
                const formattedPrice = formatPrice(item.price);
                
                // Escape data untuk lightbox
                const itemData = {
                    id: item.id,
                    name: item.name,
                    price: item.price,
                    image: item.image,
                    category: item.category,
                    description: item.description || ''
                };
                const itemJson = JSON.stringify(itemData).replace(/"/g, '&quot;');
                
                let buttonHtml = '';
                if (isSoldOut) {
                    buttonHtml = `
                        <div class="button-group">
                            <button class="cart-btn" disabled style="background:#e5e7eb; color:#6b7280;">Stok Habis</button>
                            <button class="order-btn" disabled style="background:#e5e7eb; color:#6b7280;">Stok Habis</button>
                        </div>
                    `;
                } else if (!isLoggedIn) {
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
                    <div class="menu-item">
                        <div class="menu-image-container" onclick='openLightbox(${itemJson})'>
                            <img src="${imageUrl}" alt="${escapeHtml(item.name)}" class="menu-image" onerror="this.src='/storage/default-menu.jpg'">
                            <div class="zoom-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/>
                                </svg>
                            </div>
                            ${badgeHtml}
                        </div>
                        <div class="menu-info">
                            <div class="menu-header-row">
                                <h3 class="menu-title">${escapeHtml(item.name)}</h3>
                                <span class="menu-price">Rp ${formattedPrice}</span>
                            </div>
                            <p class="menu-description">${escapeHtml(item.description) || 'Nikmati kelezatan menu kami'}</p>
                            <div class="menu-footer">
                                <span class="menu-category">${getCategoryName(item.category)}</span>
                            </div>
                            ${buttonHtml}
                        </div>
                    </div>
                `;
            });
        }
        
        container.innerHTML = htmlContent;
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
        const totalItems = getFilteredItems().length;
        const totalPages = Math.ceil(totalItems / itemsPerPage);
        if (page < 1 || page > totalPages) return;
        currentPage = page;
        renderMenu();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    
    // ==================== EVENT LISTENERS ====================
    document.addEventListener('DOMContentLoaded', function() {
        // Search input
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                currentSearch = e.target.value;
                currentPage = 1;
                renderMenu();
            });
        }
        
        // Lightbox close button
        const closeBtn = document.getElementById('closeMenuLightbox');
        const lightboxModal = document.getElementById('menuLightbox');
        
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
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown')) {
                closeAllDropdowns();
            }
        });
        
        // Initial render
        renderMenu();
    });
    
    // Add animation style
    const style = document.createElement('style');
    style.textContent = `@keyframes slideIn{from{transform:translateX(100%);opacity:0;}to{transform:translateX(0);opacity:1;}}`;
    document.head.appendChild(style);
</script>
@endsection