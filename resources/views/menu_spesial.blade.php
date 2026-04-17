@extends('layouts.app')

@section('title', 'Menu Spesial - Café Kopitiam33')

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
        --gold: #D4AF37;
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
    
    .page-header {
        background: linear-gradient(135deg, var(--sage) 0%, var(--wood) 100%);
        color: white;
        padding: 3rem 0;
        text-align: center;
    }
    
    .page-header h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .page-header p {
        font-size: 1rem;
        max-width: 600px;
        margin: 0 auto;
        opacity: 0.9;
    }
    
    .section {
        padding: 3rem 0;
    }
    
    .section-cream {
        background: var(--cream);
    }
    
    .section-header {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.75rem;
        font-weight: 600;
        color: var(--wood);
    }
    
    .section-title::after {
        content: '';
        display: block;
        width: 50px;
        height: 2px;
        background: var(--accent);
        margin: 0.5rem auto 0;
    }
    
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 1.5rem;
    }
    
    @media (min-width: 640px) {
        .menu-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (min-width: 1024px) {
        .menu-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }
    
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
    
    .menu-image {
        width: 100%;
        height: 160px;
        object-fit: cover;
    }
    
    .menu-content {
        padding: 0.75rem;
    }
    
    .menu-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--wood);
        margin-bottom: 0.25rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .menu-price {
        font-weight: bold;
        color: var(--accent);
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
    }
    
    .menu-desc {
        color: #6b7280;
        font-size: 0.7rem;
        line-height: 1.4;
        margin-bottom: 0.75rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .menu-badge {
        display: inline-block;
        background: rgba(217, 118, 66, 0.1);
        color: var(--accent);
        padding: 0.2rem 0.5rem;
        border-radius: 20px;
        font-size: 0.6rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    
    .button-group {
        display: flex;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }
    
    .cart-btn {
        flex: 1;
        background: var(--sage);
        color: white;
        padding: 0.4rem 0.5rem;
        border: none;
        border-radius: 0.375rem;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.2s;
        font-family: 'Poppins', sans-serif;
        font-size: 0.7rem;
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
        padding: 0.4rem 0.5rem;
        border: none;
        border-radius: 0.375rem;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.2s;
        font-family: 'Poppins', sans-serif;
        font-size: 0.7rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.25rem;
    }
    
    .order-btn:hover {
        background: #c0392b;
    }
    
    /* Alert Login */
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
    
    .featured-card {
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
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
        height: 260px;
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
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
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
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--wood);
        margin-bottom: 0.5rem;
    }
    
    .featured-desc {
        color: #6b7280;
        font-size: 0.8rem;
        line-height: 1.5;
        margin-bottom: 1rem;
    }
    
    .featured-price {
        font-size: 1.25rem;
        font-weight: bold;
        color: var(--accent);
        margin-bottom: 1rem;
    }
    
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
        font-size: 1.1rem;
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
    
    @media (max-width: 640px) {
        .page-header h1 {
            font-size: 1.75rem;
        }
        
        .section {
            padding: 2rem 0;
        }
        
        .featured-image {
            height: 200px;
        }
        
        .button-group {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
<!-- Header -->
<section class="page-header">
    <div class="container">
        <h1>Menu Spesial</h1>
        <p>Hidangan pilihan dengan bahan terbaik dan resep eksklusif</p>
    </div>
</section>

<!-- Featured Menu -->
@if(isset($featuredMenu) && $featuredMenu)
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Signature Dish</h2>
        </div>
        <div class="featured-card">
            <div class="featured-grid">
                <div class="featured-image" style="background-image: url('{{ $featuredMenu->image_url ?? asset('uploads/default/default-menu.jpg') }}');">
                    <div class="featured-badge">⭐ {{ $featuredMenu->badge ?? 'Signature' }}</div>
                </div>
                <div class="featured-content">
                    <span class="featured-category">Chef's Signature</span>
                    <h3 class="featured-title">{{ $featuredMenu->name }}</h3>
                    <p class="featured-desc">{{ $featuredMenu->description ?? 'Nikmati kelezatan menu spesial kami' }}</p>
                    <div class="featured-price">Rp {{ number_format($featuredMenu->price, 0, ',', '.') }}</div>
                    <div class="button-group">
                        @auth
                            <button class="cart-btn" onclick="addToCart({{ $featuredMenu->id }})">🛒 Keranjang</button>
                            <button class="order-btn" onclick="openOrderModal({{ $featuredMenu->id }})">📝 Pesan</button>
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

<!-- Menu Spesial Grid -->
<section class="section section-cream">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Menu Spesial</h2>
        </div>
        <div class="menu-grid">
            @forelse($regularMenus ?? [] as $menu)
            <div class="menu-card">
                <img src="{{ $menu->image_url ?? asset('uploads/default/default-menu.jpg') }}" alt="{{ $menu->name }}" class="menu-image" loading="lazy">
                <div class="menu-content">
                    <h4 class="menu-title">{{ $menu->name }}</h4>
                    <div class="menu-price">Rp {{ number_format($menu->price, 0, ',', '.') }}</div>
                    <p class="menu-desc">{{ $menu->description ?? 'Nikmati kelezatan menu spesial kami' }}</p>
                    @if($menu->badge)
                        <span class="menu-badge">{{ $menu->badge }}</span>
                    @endif
                    <div class="button-group">
                        @auth
                            <button class="cart-btn" onclick="addToCart({{ $menu->id }})">🛒 Keranjang</button>
                            <button class="order-btn" onclick="openOrderModal({{ $menu->id }})">📝 Pesan</button>
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
            @empty
            <div class="empty-state">
                <p>Belum ada menu spesial saat ini</p>
                <p style="font-size: 0.8rem; margin-top: 0.5rem;">Kunjungi lagi nanti untuk menu menarik</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Modal -->
<div id="orderModal" class="quantity-modal">
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
    const menuSpesial = @json($menuSpesial ?? []);
    const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
    
    console.log('Menu Spesial Data:', menuSpesial);
    
    let cart = JSON.parse(localStorage.getItem('kopitiam_cart')) || [];
    let selectedItem = null;
    let selectedQty = 1;
    
    function requireLogin() {
        if (!isLoggedIn) {
            if(confirm('🔒 Anda harus login terlebih dahulu. Buka halaman login?')) {
                window.location.href = '{{ route("login") }}';
            }
            return false;
        }
        return true;
    }
    
    // Fungsi untuk user yang sudah login
    function addToCart(itemId) {
        const item = menuSpesial.find(m => m.id === itemId);
        if (!item) {
            showNotification('Error: Menu tidak ditemukan');
            return;
        }
        
        const existing = cart.find(c => c.id === itemId && c.is_menu_spesial === true);
        if (existing) {
            existing.quantity += 1;
        } else {
            cart.push({
                id: item.id,
                name: item.name,
                price: item.price,
                quantity: 1,
                image: item.image,
                is_menu_spesial: true,
                type: 'menu_spesial'
            });
        }
        
        localStorage.setItem('kopitiam_cart', JSON.stringify(cart));
        showNotification(`${item.name} ditambahkan ke keranjang! 🛒`);
        window.dispatchEvent(new CustomEvent('cart-updated'));
        
        if (typeof updateCartCount === 'function') {
            updateCartCount();
        }
    }
    
    function openOrderModal(itemId) {
        selectedItem = menuSpesial.find(m => m.id === itemId);
        if (!selectedItem) {
            showNotification('Error: Menu tidak ditemukan');
            return;
        }
        
        selectedQty = 1;
        document.getElementById('qtyValue').textContent = selectedQty;
        document.getElementById('modalTitle').textContent = selectedItem.name;
        document.getElementById('orderModal').classList.add('show');
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
            price: selectedItem.price,
            quantity: selectedQty,
            image: selectedItem.image,
            is_menu_spesial: true,
            type: 'menu_spesial'
        };
        
        console.log('Sending order:', orderItem);
        
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
            console.log('Server response:', data);
            
            if (data.success) {
                showNotification('✅ Pesanan berhasil dibuat!');
                setTimeout(() => {
                    window.location.href = '{{ route("orders.history") }}';
                }, 1500);
            } else {
                showNotification('❌ Gagal: ' + (data.message || 'Terjadi kesalahan'));
                confirmBtn.textContent = originalText;
                confirmBtn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('⚠️ Terjadi kesalahan: ' + error.message);
            confirmBtn.textContent = originalText;
            confirmBtn.disabled = false;
        });
        
        closeModal();
    }
    
    function closeModal() {
        document.getElementById('orderModal').classList.remove('show');
        selectedItem = null;
        selectedQty = 1;
    }
    
    function showNotification(message) {
        const oldNotif = document.querySelector('.custom-notification');
        if (oldNotif) oldNotif.remove();
        
        const notif = document.createElement('div');
        notif.className = 'custom-notification';
        notif.style.cssText = `
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
        `;
        notif.textContent = message;
        document.body.appendChild(notif);
        
        setTimeout(() => {
            notif.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notif.remove(), 300);
        }, 3000);
    }
    
    document.getElementById('orderModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
    
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    `;
    document.head.appendChild(style);
</script>
@endsection