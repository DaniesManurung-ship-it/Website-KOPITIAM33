{{-- resources/views/cart.blade.php - IMPROVED VERSION --}}
@extends('layouts.app')

@section('title', 'Keranjang Belanja - Café Kopitiam33')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/cart.css') }}">
<style>
    /* Enhanced animations & transitions */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .cart-section {
        animation: fadeInUp 0.6s ease;
    }

    .product-info {
        animation: fadeInUp 0.4s ease backwards;
    }

    @media (prefers-reduced-motion: no-preference) {
        .cart-table tr {
            animation: fadeInUp 0.5s ease backwards;
        }
    }
</style>
@endpush

@section('content')
<!-- Loading Overlay with enhanced styling -->
<div id="loadingOverlay" class="loading-overlay">
    <div class="spinner"></div>
    <div class="loading-text">⏳ Memproses pesanan Anda...</div>
</div>

<!-- Cart Header - Professional Design -->
<section class="cart-header">
    <div class="container">
        <h1>🛒 Keranjang Belanja</h1>
        <p>Tinjau pesanan Anda sebelum melakukan checkout di Kopitiam33</p>
    </div>
</section>

<!-- Cart Content -->
<section class="cart-section">
    <div class="container">
        <div id="cartContent"></div>
    </div>
</section>

<script>
    // ========== CART STATE MANAGEMENT ==========
    let cart = {!! json_encode(array_values($cart ?? [])) !!};
    const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
    const userId = {{ Auth::id() ?? 'null' }};
    
    // Load cart dari server saat page load
    function loadCartFromServer() {
        if (!isLoggedIn) {
            const saved = localStorage.getItem('kopitiam_cart');
            if (saved) {
                try {
                    cart = JSON.parse(saved);
                } catch(e) {
                    cart = [];
                }
            } else {
                cart = [];
            }
        }
        // Jika sudah login, 'cart' sudah diisi dari server melalui Blade (lebih cepat)
        renderCart();
    }
    
    // ========== IMAGE URL HANDLER ==========
    function getImageUrl(image) {
        if (!image) {
            return '/storage/default-menu.jpg';
        }
        
        if (image.startsWith('http')) {
            return image;
        }
        
        if (image.startsWith('/storage/')) {
            return image;
        }
        
        if (image.startsWith('storage/')) {
            return '/' + image;
        }
        
        if (image.startsWith('uploads/')) {
            return '/' + image;
        }
        
        return '/storage/' + image;
    }
    
    // ========== PRODUCT BADGE ==========
    function getProductBadge(item) {
        if (item.is_menu_spesial) {
            return '<span class="product-badge badge-spesial">⭐ Menu Spesial</span>';
        }
        return '';
    }
    
    // ========== CART COUNT UPDATE ==========
    function updateCartCount() {
        const cartCount = document.querySelector('.cart-count');
        if (cartCount) {
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            cartCount.textContent = totalItems;
            if (totalItems > 0) {
                cartCount.style.display = 'flex';
            } else {
                cartCount.style.display = 'none';
            }
        }
    }
    
    // ========== LOGIN CHECK ==========
    function requireLogin() {
        if (!isLoggedIn) {
            window.customConfirmAction('🔒 Anda harus login terlebih dahulu untuk melanjutkan checkout. Buka halaman login?', () => {
                window.location.href = '{{ route("login") }}';
            });
            return false;
        }
        return true;
    }
    
    // ========== MAIN RENDER FUNCTION ==========
    function renderCart() {
        const container = document.getElementById('cartContent');
        
        if (!cart || cart.length === 0) {
            container.innerHTML = `
                <div class="empty-cart">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <h3>Keranjang Kosong</h3>
                    <p>Belum ada item di keranjang Anda. Mari mulai pesan menu favorit Anda dari Kopitiam33!</p>
                    <a href="{{ route('menu') }}" class="shop-btn">🍽️ Jelajahi Menu</a>
                </div>
            `;
            updateCartCount();
            return;
        }
        
        const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        
        let itemsHtml = '';
        cart.forEach((item, index) => {
            const imageUrl = getImageUrl(item.image);
            const subtotal = item.price * item.quantity;
            itemsHtml += `
                <tr>
                    <td>
                        <div class="product-info">
                            <img src="${imageUrl}" alt="${item.name}" class="product-image" onerror="this.src='/storage/default-menu.jpg'">
                            <div class="product-details">
                                <h4>${escapeHtml(item.name)}</h4>
                                ${getProductBadge(item)}
                            </div>
                        </div>
                    </td>
                    <td class="item-price">Rp${item.price.toLocaleString('id-ID')}</td>
                    <td>
                        <div class="quantity-control">
                            <button class="qty-btn" onclick="updateQuantity(${index}, -1)" title="Kurangi jumlah" aria-label="Kurangi">−</button>
                            <span class="qty-value" aria-live="polite">${item.quantity}</span>
                            <button class="qty-btn" onclick="updateQuantity(${index}, 1)" title="Tambah jumlah" aria-label="Tambah">+</button>
                        </div>
                    </td>
                    <td class="item-price">Rp${subtotal.toLocaleString('id-ID')}</td>
                    <td>
                        <button class="remove-btn" onclick="removeItem(${index})" title="Hapus item dari keranjang" aria-label="Hapus">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </td>
                </tr>
            `;
        });
        
        // Conditional checkout button
        let checkoutButtonHtml = '';
        if (!isLoggedIn) {
            checkoutButtonHtml = `
                <div class="login-alert">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <span>🔒 Silakan <a href="{{ route('login') }}">login</a> terlebih dahulu untuk melanjutkan checkout</span>
                </div>
                <button class="checkout-btn disabled" onclick="requireLogin()" disabled>
                    🔒 Login untuk Checkout
                </button>
            `;
        } else {
            checkoutButtonHtml = `
                <button class="checkout-btn" onclick="checkout()" title="Lanjutkan ke pembayaran">
                    ✅ Lanjutkan Pesanan
                </button>
            `;
        }
        
        container.innerHTML = `
            <div class="cart-grid">
                <div class="cart-items">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            ${itemsHtml}
                        </tbody>
                    </table>
                </div>
                
                <div class="cart-summary">
                    <h3 class="summary-title">📋 Ringkasan Pesanan</h3>
                    
                    <div class="summary-row total">
                        <span class="summary-label">Total Pesanan</span>
                        <span class="summary-value" id="totalPrice">Rp ${total.toLocaleString('id-ID')}</span>
                    </div>
                    
                    <!-- Form Pemesanan -->
                    <div class="order-form-group">
                        <label for="floorSelect">Lantai / Area <span style="color:#D63031">*</span></label>
                        <select id="floorSelect" class="form-select" required aria-describedby="floor-help">
                            <option value="">-- Pilih Area --</option>
                            <option value="Lantai 1">Lantai 1</option>
                            <option value="Lantai 2">Lantai 2</option>
                            <option value="Outdoor">Outdoor</option>
                        </select>
                        
                        <label for="tableNumber">Nomor Meja <span style="color:#D63031">*</span></label>
                        <input type="text" id="tableNumber" class="form-input" placeholder="Contoh: 12" required aria-describedby="table-help">

                        <label for="voucherCode">Kode Voucher <span style="opacity:0.6">(Opsional)</span></label>
                        <input type="text" id="voucherCode" class="form-input" placeholder="Masukkan kode voucher" style="text-transform: uppercase;">
                    </div>
                    
                    ${checkoutButtonHtml}
                    
                    <div class="payment-note">
                        💳Silahkan Lakukan Pembayaran😊
                    </div>
                </div>
            </div>
        `;
        
        updateCartCount();
    }
    
    // ========== UTILITY FUNCTIONS ==========
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // ========== QUANTITY UPDATE ==========
    function updateQuantity(index, delta) {
        if (cart[index]) {
            const newQty = cart[index].quantity + delta;
            if (newQty <= 0) {
                removeItem(index);
            } else {
                if (!isLoggedIn) {
                    cart[index].quantity = newQty;
                    localStorage.setItem('kopitiam_cart', JSON.stringify(cart));
                    window.dispatchEvent(new CustomEvent('cart-updated'));
                    showNotification(`Jumlah ${cart[index]?.name} diperbarui`);
                    renderCart();
                    return;
                }
                
                const itemKey = cart[index].type + '_' + cart[index].id;
                
                fetch('{{ route("cart.update", ":id") }}'.replace(':id', itemKey), {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ quantity: newQty })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        cart = data.cart || [];
                        showNotification(`✏️ Jumlah ${cart[index]?.name} diperbarui`);
                        renderCart();
                    } else {
                        showNotification('Gagal mengubah kuantitas', true);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Gagal mengubah kuantitas', true);
                });
            }
        }
    }
    
    // ========== REMOVE ITEM ==========
    function removeItem(index) {
        const itemName = cart[index]?.name || 'Item';
        
        if (!isLoggedIn) {
            cart.splice(index, 1);
            localStorage.setItem('kopitiam_cart', JSON.stringify(cart));
            window.dispatchEvent(new CustomEvent('cart-updated'));
            showNotification(`🗑️ ${itemName} dihapus dari keranjang`);
            renderCart();
            return;
        }

        const itemKey = cart[index].type + '_' + cart[index].id;
        
        fetch('{{ route("cart.destroy", ":id") }}'.replace(':id', itemKey), {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                cart = data.cart || [];
                showNotification(`🗑️ ${itemName} dihapus dari keranjang`);
                renderCart();
            } else {
                showNotification('Gagal menghapus item', true);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Gagal menghapus item', true);
        });
    }
    
    // ========== LOADING HANDLERS ==========
    function showLoading() {
        const overlay = document.getElementById('loadingOverlay');
        if (overlay) overlay.classList.add('show');
    }
    
    function hideLoading() {
        const overlay = document.getElementById('loadingOverlay');
        if (overlay) overlay.classList.remove('show');
    }
    
    // ========== NOTIFICATION SYSTEM ==========
    function showNotification(message, isError = false) {
        const notif = document.createElement('div');
        notif.className = 'notification';
        if (isError) {
            notif.style.background = '#D63031';
            notif.innerHTML = `❌ ${message}`;
        } else {
            notif.style.background = 'var(--sage)';
            notif.innerHTML = `✅ ${message}`;
        }
        document.body.appendChild(notif);
        
        setTimeout(() => {
            notif.style.animation = 'slideOut 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
            setTimeout(() => notif.remove(), 400);
        }, 3500);
    }
    
    // ========== CHECKOUT FUNCTION ==========
    function checkout() {
        if (cart.length === 0) {
            showNotification('Keranjang masih kosong!', true);
            return;
        }
        
        if (!isLoggedIn) {
            showNotification('Silakan login terlebih dahulu!', true);
            setTimeout(() => {
                window.location.href = '{{ route("login") }}';
            }, 1500);
            return;
        }
        
        const floor = document.getElementById('floorSelect').value;
        const tableNumber = document.getElementById('tableNumber').value;
        const voucherCode = document.getElementById('voucherCode') ? document.getElementById('voucherCode').value : '';
        
        if (!floor || !tableNumber) {
            showNotification('Silakan isi Nomor Meja dan Area/Lantai terlebih dahulu!', true);
            return;
        }
        
        if (tableNumber.trim() === '') {
            showNotification('Nomor meja tidak boleh kosong!', true);
            return;
        }
        
        showLoading();
        
        fetch('{{ route("order.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                cart: cart,
                table_number: tableNumber.trim(),
                floor: floor,
                voucher_code: voucherCode.trim(),
                payment_method: 'Cash'
            })
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.success) {
                // Keranjang sudah dihapus di backend (OrderController)
                cart = [];
                localStorage.removeItem('kopitiam_cart');
                window.dispatchEvent(new CustomEvent('cart-updated'));
                showNotification('🎉 Pesanan berhasil dibuat! Mengalihkan ke halaman pembayaran...');
                setTimeout(() => {
                    window.location.href = `/order/${data.order_id}/payment`;
                }, 1800);
            } else {
                showNotification(data.message || 'Gagal menyimpan pesanan', true);
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showNotification('❌ Terjadi kesalahan. Silakan coba lagi.', true);
        });
    }
    
    // ========== INITIALIZE ON DOM READY ==========
    document.addEventListener('DOMContentLoaded', () => {
        loadCartFromServer();
        
        // Add enter key support for table number input
        const tableInput = document.getElementById('tableNumber');
        if (tableInput) {
            tableInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    checkout();
                }
            });
        }
    });
</script>
@endsection