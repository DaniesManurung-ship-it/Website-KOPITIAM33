{{-- resources/views/cart.blade.php --}}
@extends('layouts.app')

@section('title', 'Keranjang Belanja - Café Kopitiam33')

@push('styles')
<style>
    /* RESET & OVERRIDE - Pastikan warna sage menang */
    .cart-header {
        background: #8BA888 !important;
        background-color: #8BA888 !important;
        color: white !important;
        padding: 3rem 0 !important;
        text-align: center !important;
    }
    
    .cart-header h1 {
        font-family: 'Playfair Display', serif !important;
        font-size: 2.5rem !important;
        font-weight: 700 !important;
        margin-bottom: 0.5rem !important;
        color: white !important;
    }
    
    .cart-header p {
        font-size: 1rem !important;
        max-width: 600px !important;
        margin: 0 auto !important;
        opacity: 0.9 !important;
        color: white !important;
    }
    
    /* Pastikan tidak ada gradient atau background lain yang mengganggu */
    .cart-header::before,
    .cart-header::after {
        display: none !important;
    }
    
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
        --border: #E5E7EB;
        --dark: #4A3728;
    }
    
    body {
        font-family: 'Poppins', sans-serif;
        background: #F5EFE6;
    }
    
    .container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    
    /* Cart Section */
    .cart-section {
        padding: 3rem 0;
    }
    
    .cart-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    @media (min-width: 1024px) {
        .cart-grid {
            grid-template-columns: 1.5fr 1fr;
        }
    }
    
    /* Cart Items Table */
    .cart-items {
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    
    .cart-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .cart-table th {
        text-align: left;
        padding: 1rem;
        background: var(--cream);
        color: var(--wood);
        font-weight: 600;
        font-size: 0.875rem;
    }
    
    .cart-table td {
        padding: 1rem;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }
    
    .cart-table tr:last-child td {
        border-bottom: none;
    }
    
    /* Product Info */
    .product-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .product-image {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 0.75rem;
        border: 1px solid var(--border);
        background: #f9fafb;
    }
    
    .product-details h4 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--wood);
        margin-bottom: 0.25rem;
    }
    
    .product-badge {
        display: inline-block;
        font-size: 0.6rem;
        padding: 0.15rem 0.5rem;
        border-radius: 12px;
        margin-top: 0.25rem;
    }
    
    .badge-promo {
        background: #FEE2E2;
        color: #DC2626;
    }
    
    .badge-spesial {
        background: #FEF3C7;
        color: #D97706;
    }
    
    /* Quantity Control */
    .quantity-control {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .qty-btn {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: 1px solid var(--sage);
        background: white;
        cursor: pointer;
        font-size: 1rem;
        transition: all 0.2s;
    }
    
    .qty-btn:hover {
        background: var(--sage);
        color: white;
        transform: scale(1.05);
    }
    
    .qty-value {
        min-width: 35px;
        text-align: center;
        font-weight: 600;
    }
    
    .item-price {
        font-weight: 600;
        color: var(--accent);
    }
    
    .remove-btn {
        background: none;
        border: none;
        cursor: pointer;
        color: #ef4444;
        transition: all 0.2s;
        padding: 0.25rem;
        border-radius: 50%;
    }
    
    .remove-btn:hover {
        transform: scale(1.1);
        background: #fee2e2;
    }
    
    /* Cart Summary */
    .cart-summary {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        position: sticky;
        top: 100px;
    }
    
    .summary-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--wood);
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--cream);
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        font-size: 0.875rem;
    }
    
    .summary-row.total {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 2px solid var(--cream);
        font-weight: 700;
        font-size: 1.125rem;
        color: var(--wood);
    }
    
    .summary-label {
        color: #6b7280;
    }
    
    .summary-value {
        font-weight: 600;
        color: var(--accent);
    }
    
    .summary-row.total .summary-value {
        color: var(--accent);
        font-size: 1.5rem;
        font-weight: 800;
    }
    
    .checkout-btn {
        width: 100%;
        background: var(--accent);
        color: white;
        padding: 1rem;
        border: none;
        border-radius: 0.75rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s;
        margin-top: 1rem;
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .checkout-btn:hover {
        background: #c0392b;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(217, 118, 66, 0.3);
    }
    
    .checkout-btn.disabled {
        background: #e5e7eb;
        color: #6b7280;
        cursor: not-allowed;
        transform: none;
    }
    
    .checkout-btn.disabled:hover {
        transform: none;
        box-shadow: none;
    }
    
    .payment-note {
        font-size: 0.65rem;
        color: #6b7280;
        text-align: center;
        margin-top: 0.75rem;
        padding: 0.5rem;
        background: var(--cream);
        border-radius: 0.5rem;
    }
    
    /* Login Alert */
    .login-alert {
        background: #FEF3C7;
        color: #D97706;
        border-radius: 0.5rem;
        padding: 0.75rem;
        margin-bottom: 1rem;
        text-align: center;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .login-alert svg {
        width: 20px;
        height: 20px;
    }
    
    .login-alert a {
        color: #D97706;
        font-weight: 600;
        text-decoration: underline;
    }
    
    /* Empty Cart */
    .empty-cart {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 1rem;
    }
    
    .empty-cart svg {
        width: 80px;
        height: 80px;
        color: #d1d5db;
        margin-bottom: 1rem;
    }
    
    .empty-cart h3 {
        font-size: 1.25rem;
        color: var(--wood);
        margin-bottom: 0.5rem;
    }
    
    .empty-cart p {
        color: #6b7280;
        margin-bottom: 1.5rem;
    }
    
    .shop-btn {
        display: inline-block;
        background: var(--sage);
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 0.5rem;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .shop-btn:hover {
        background: var(--wood);
        transform: translateY(-2px);
    }
    
    /* Loading Overlay */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.7);
        backdrop-filter: blur(4px);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 1rem;
    }
    
    .loading-overlay.show {
        display: flex;
    }
    
    .spinner {
        width: 50px;
        height: 50px;
        border: 3px solid #f3f3f3;
        border-top: 3px solid var(--accent);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    .loading-text {
        color: white;
        font-size: 0.9rem;
        font-weight: 500;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    /* Notification */
    .notification {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: var(--sage);
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        font-size: 14px;
        z-index: 1000;
        animation: slideIn 0.3s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        font-weight: 500;
    }
    
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .cart-header h1 {
            font-size: 1.75rem !important;
        }
        
        .cart-header p {
            font-size: 0.875rem !important;
        }
        
        .cart-table th, .cart-table td {
            padding: 0.75rem;
        }
        
        .product-info {
            flex-direction: column;
            text-align: center;
        }
        
        .product-image {
            width: 60px;
            height: 60px;
        }
        
        .quantity-control {
            justify-content: center;
        }
        
        .cart-summary {
            position: static;
        }
        
        .summary-row.total .summary-value {
            font-size: 1.25rem;
        }
    }
    
    @media (max-width: 640px) {
        .cart-table th:nth-child(2),
        .cart-table td:nth-child(2) {
            display: none;
        }
        
        .cart-table th, .cart-table td {
            font-size: 0.8rem;
        }
    }
</style>
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
    let cart = JSON.parse(localStorage.getItem('kopitiam_cart')) || [];
    const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
    
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
                    <td class="item-price">Rp ${item.price.toLocaleString('id-ID')}</td>
                    <td>
                        <div class="quantity-control">
                            <button class="qty-btn" onclick="updateQuantity(${index}, -1)">−</button>
                            <span class="qty-value">${item.quantity}</span>
                            <button class="qty-btn" onclick="updateQuantity(${index}, 1)">+</button>
                        </div>
                    </td>
                    <td class="item-price">Rp ${subtotal.toLocaleString('id-ID')}</td>
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
                cart.splice(index, 1);
                showNotification('Item dihapus dari keranjang');
            } else {
                cart[index].quantity = newQty;
                showNotification(`Jumlah ${cart[index].name} diperbarui`);
            }
            saveCart();
            renderCart();
        }
    }
    
    function removeItem(index) {
        const itemName = cart[index]?.name || 'Item';
        cart.splice(index, 1);
        saveCart();
        renderCart();
        showNotification(`${itemName} dihapus dari keranjang`);
    }
    
    function saveCart() {
        localStorage.setItem('kopitiam_cart', JSON.stringify(cart));
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
                localStorage.removeItem('kopitiam_cart');
                cart = [];
                window.dispatchEvent(new CustomEvent('cart-updated'));
                showNotification('Pesanan berhasil dibuat! Silakan ambil pesanan di kasir.');
                setTimeout(() => {
                    window.location.href = '{{ route("orders.history") }}';
                }, 2000);
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
        renderCart();
    });
</script>
@endsection