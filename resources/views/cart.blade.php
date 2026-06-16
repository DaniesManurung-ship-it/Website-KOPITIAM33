{{-- resources/views/cart.blade.php --}}
@extends('layouts.app')

@section('title', 'Keranjang Belanja - Café Kopitiam33')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endpush

@section('content')
<!-- Loading Overlay -->
<div id="loadingOverlay" class="loading-overlay">
    <div class="spinner"></div>
    <div class="loading-text">Memproses pesanan...</div>
</div>

<!-- Cart Header - SOLID SAGE BACKGROUND -->
<section class="cart-header" style="background: #8BA888 !important; background-color: #8BA888 !important;">
    <div class="container">
        <h1>🛒 Keranjang Belanja</h1>
        <p>Tinjau pesanan Anda sebelum melakukan checkout</p>
    </div>
</section>

<!-- Cart Content -->
<section class="cart-section">
    <div class="container">
        <div id="cartContent"></div>
    </div>
</section>

<script>
    // ========== FETCH CART DATA FROM SERVER (PER USER) ==========
    let cart = [];
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
            renderCart();
            return;
        }
        
        fetch('{{ route("cart.get") }}', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                cart = data.cart;
            }
            renderCart();
        })
        .catch(error => {
            console.error('Error loading cart:', error);
            renderCart();
        });
    }
    
    // Fungsi untuk mendapatkan URL gambar yang benar
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
    
    function getProductBadge(item) {
        if (item.is_promo) {
            return '<span class="product-badge badge-promo">🔥 Promo Spesial</span>';
        }
        if (item.is_menu_spesial) {
            return '<span class="product-badge badge-spesial">⭐ Menu Spesial</span>';
        }
        return '';
    }
    
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
    
    function requireLogin() {
        if (!isLoggedIn) {
            if(confirm('🔒 Anda harus login terlebih dahulu untuk melanjutkan checkout. Buka halaman login?')) {
                window.location.href = '{{ route("login") }}';
            }
            return false;
        }
        return true;
    }
    
    function renderCart() {
        const container = document.getElementById('cartContent');
        
        if (!cart || cart.length === 0) {
            container.innerHTML = `
                <div class="empty-cart">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <h3>Keranjang Kosong</h3>
                    <p>Belum ada item di keranjang Anda. Yuk mulai pesan!</p>
                    <a href="{{ route('menu') }}" class="shop-btn">🍽️ Mulai Belanja</a>
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
                            <button class="qty-btn" onclick="updateQuantity(${index}, -1)">−</button>
                            <span class="qty-value">${item.quantity}</span>
                            <button class="qty-btn" onclick="updateQuantity(${index}, 1)">+</button>
                        </div>
                    </td>
                    <td class="item-price">Rp${subtotal.toLocaleString('id-ID')}</td>
                    <td>
                        <button class="remove-btn" onclick="removeItem(${index})" title="Hapus item">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </td>
                </tr>
            `;
        });
        
        // Tampilkan tombol checkout yang berbeda untuk guest dan user
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
                <button class="checkout-btn" onclick="checkout()">
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
                        <span class="summary-value">Rp ${total.toLocaleString('id-ID')}</span>
                    </div>
                    
                    ${checkoutButtonHtml}
                    
                    <div class="payment-note">
                        💳 Pembayaran dilakukan di tempat saat mengambil pesanan
                    </div>
                </div>
            </div>
        `;
        
        updateCartCount();
    }
    
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
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
                        // Update local cart dengan response dari server
                        cart = data.cart || [];
                        showNotification(`Jumlah ${cart[index]?.name} diperbarui`);
                        renderCart();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Gagal mengubah kuantitas', true);
                });
            }
        }
    }
    
    function removeItem(index) {
        const itemName = cart[index]?.name || 'Item';
        
        if (!isLoggedIn) {
            cart.splice(index, 1);
            localStorage.setItem('kopitiam_cart', JSON.stringify(cart));
            window.dispatchEvent(new CustomEvent('cart-updated'));
            showNotification(`${itemName} dihapus dari keranjang`);
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
                // Update local cart dengan response dari server
                cart = data.cart || [];
                showNotification(`${itemName} dihapus dari keranjang`);
                renderCart();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Gagal menghapus item', true);
        });
    }
    
    function saveCart() {
        // Tidak perlu save ke localStorage lagi, semua disimpan di server
        window.dispatchEvent(new CustomEvent('cart-updated'));
    }
    
    function showLoading() {
        const overlay = document.getElementById('loadingOverlay');
        if (overlay) overlay.classList.add('show');
    }
    
    function hideLoading() {
        const overlay = document.getElementById('loadingOverlay');
        if (overlay) overlay.classList.remove('show');
    }
    
    function showNotification(message, isError = false) {
        const notif = document.createElement('div');
        notif.className = 'notification';
        notif.style.background = isError ? '#ef4444' : 'var(--sage)';
        notif.innerHTML = isError ? `❌ ${message}` : `✅ ${message}`;
        document.body.appendChild(notif);
        
        setTimeout(() => {
            notif.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notif.remove(), 300);
        }, 3000);
    }
    
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
                payment_method: 'Cash'
            })
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.success) {
                // Clear server-side cart
                fetch('{{ route("cart.clear") }}', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                }).then(() => {
                    cart = [];
                    localStorage.removeItem('kopitiam_cart');
                    window.dispatchEvent(new CustomEvent('cart-updated'));
                    showNotification('Pesanan berhasil dibuat! Silakan ambil pesanan di kasir.');
                    setTimeout(() => {
                        window.location.href = '{{ route("orders.history") }}';
                    }, 2000);
                });
            } else {
                showNotification(data.message || 'Gagal menyimpan pesanan', true);
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showNotification('Terjadi kesalahan. Silakan coba lagi.', true);
        });
    }
    
    document.addEventListener('DOMContentLoaded', () => {
        loadCartFromServer();
    });
</script>
@endsection