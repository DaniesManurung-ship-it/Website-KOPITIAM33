<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Café Kopitiam33</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
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
        
        /* Navbar Styles */
        .nav-container {
            background: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .nav-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .nav-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 64px;
        }
        
        /* Logo */
        .logo-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }
        
        .logo-circle {
            width: 40px;
            height: 40px;
            background: var(--sage);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .logo-text {
            color: white;
            font-weight: bold;
            font-size: 1.25rem;
        }
        
        .logo-brand {
            color: var(--wood);
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 600;
        }
        
        /* Desktop Menu */
        .desktop-menu {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        
        @media (max-width: 768px) {
            .desktop-menu {
                display: none;
            }
        }
        
        .nav-link {
            text-decoration: none;
            font-weight: 500;
            color: var(--wood);
            transition: color 0.2s;
            padding: 0.5rem 0;
        }
        
        .nav-link:hover {
            color: var(--accent);
        }
        
        .nav-link-active {
            color: var(--sage) !important;
            border-bottom: 2px solid var(--sage);
        }
        
        /* Dropdown Styles */
        .dropdown {
            position: relative;
        }
        
        .dropdown-button {
            background: none;
            border: none;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            color: var(--wood);
            padding: 0.5rem 0;
            transition: color 0.2s;
        }
        
        .dropdown-button:hover {
            color: var(--accent);
        }
        
        .dropdown-button-active {
            color: var(--sage) !important;
        }
        
        .dropdown-icon {
            width: 1rem;
            height: 1rem;
            transition: transform 0.2s ease;
        }
        
        .dropdown-icon.rotate {
            transform: rotate(180deg);
        }
        
        .dropdown-menu {
            position: absolute;
            top: calc(100% + 5px);
            left: 0;
            min-width: 180px;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15);
            padding: 0.5rem 0;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s, visibility 0.2s;
        }
        
        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
        }
        
        .dropdown-item {
            display: block;
            padding: 0.6rem 1.2rem;
            font-size: 0.875rem;
            color: #374151;
            text-decoration: none;
            transition: all 0.2s;
            white-space: nowrap;
        }
        
        .dropdown-item:hover {
            background: var(--cream);
            color: var(--sage);
        }
        
        /* Cart Styles */
        .cart-button {
            position: relative;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--wood);
            padding: 0.5rem;
        }
        
        .cart-icon {
            width: 24px;
            height: 24px;
        }
        
        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--accent);
            color: white;
            font-size: 0.7rem;
            font-weight: bold;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .cart-dropdown {
            position: absolute;
            right: 0;
            top: calc(100% + 5px);
            width: 320px;
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            z-index: 9999;
            border: 1px solid #f3f4f6;
        }
        
        .cart-header {
            padding: 0.75rem 1rem;
            background: rgba(139, 168, 136, 0.1);
            border-bottom: 1px solid rgba(139, 168, 136, 0.2);
        }
        
        .cart-title {
            font-weight: 600;
            color: var(--wood);
        }
        
        .cart-items {
            max-height: 350px;
            overflow-y: auto;
            padding: 0.75rem;
        }
        
        .cart-empty {
            text-align: center;
            padding: 1.5rem;
            color: #6b7280;
        }
        
        .cart-item {
            display: flex;
            gap: 0.75rem;
            padding: 0.5rem 0;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .cart-item:last-child {
            border-bottom: none;
        }
        
        .cart-item-info {
            flex: 1;
        }
        
        .cart-item-name {
            font-weight: 500;
            font-size: 0.875rem;
            color: #1f2937;
        }
        
        .cart-item-price {
            color: var(--accent);
            font-size: 0.75rem;
        }
        
        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.25rem;
        }
        
        .quantity-btn {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #f3f4f6;
            border: none;
            cursor: pointer;
            font-size: 0.75rem;
        }
        
        .quantity-value {
            font-size: 0.75rem;
            font-weight: 500;
            width: 20px;
            text-align: center;
        }
        
        .remove-item {
            background: none;
            border: none;
            cursor: pointer;
            color: #9ca3af;
        }
        
        .cart-footer {
            padding: 0.75rem 1rem;
            background: #f9fafb;
            border-top: 1px solid #f3f4f6;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }
        
        .total-price {
            color: var(--wood);
            font-weight: bold;
        }
        
        .checkout-btn {
            width: 100%;
            background: var(--accent);
            color: white;
            padding: 0.5rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: background 0.2s;
        }
        
        .checkout-btn:hover {
            background: #c0392b;
        }
        
        /* Profile Dropdown */
        .profile-dropdown {
            position: relative;
        }
        
        .profile-button {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--wood);
            padding: 0.5rem;
        }
        
        .profile-icon {
            width: 18px;
            height: 18px;
        }
        
        .profile-menu {
            position: absolute;
            right: 0;
            top: calc(100% + 5px);
            min-width: 200px;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 0;
            z-index: 9999;
        }
        
        .profile-menu-item {
            display: block;
            width: 100%;
            text-align: left;
            padding: 0.6rem 1rem;
            color: #374151;
            text-decoration: none;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 0.875rem;
            transition: background 0.2s;
        }
        
        .profile-menu-item:hover {
            background: #f3f4f6;
            color: var(--sage);
        }
        
        /* Mobile Menu */
        .mobile-buttons {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        @media (min-width: 769px) {
            .mobile-buttons {
                display: none;
            }
        }
        
        .mobile-menu-btn {
            background: none;
            border: none;
            color: var(--wood);
            cursor: pointer;
        }
        
        .mobile-menu {
            display: none;
            padding: 1rem 0;
            border-top: 1px solid #e5e7eb;
        }
        
        .mobile-menu.open {
            display: block;
        }
        
        .mobile-menu-links {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .mobile-link {
            text-decoration: none;
            color: var(--wood);
        }
        
        .mobile-link-active {
            color: var(--sage) !important;
            font-weight: 600;
        }
        
        .mobile-dropdown-btn {
            width: 100%;
            text-align: left;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--wood);
            font-size: 1rem;
        }
        
        .mobile-submenu {
            padding-left: 1rem;
            margin-top: 0.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .mobile-submenu-link {
            text-decoration: none;
            color: var(--wood);
            font-size: 0.875rem;
        }
        
        .mobile-auth-section {
            padding-top: 0.5rem;
            border-top: 1px solid #e5e7eb;
        }
        
        /* Notification Styles */
        .cart-notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--sage);
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 14px;
            z-index: 9999;
            animation: slideIn 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            font-family: 'Poppins', sans-serif;
        }
        
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
        
        [x-cloak] {
            display: none !important;
        }
        
        /* Login/Register Buttons */
        .auth-buttons {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .btn-login {
            background: transparent;
            border: 1px solid var(--sage);
            color: var(--sage);
            padding: 0.4rem 1rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .btn-login:hover {
            background: var(--sage);
            color: white;
        }
        
        .btn-register {
            background: var(--accent);
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .btn-register:hover {
            background: #c0392b;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .auth-buttons {
                gap: 0.5rem;
            }
            
            .btn-login, .btn-register {
                padding: 0.3rem 0.75rem;
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body>

<nav class="nav-container" x-data="navigationData()" x-init="init">
    <div class="nav-inner">
        <div class="nav-content">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="logo-link">
                <div class="logo-circle">
                    <span class="logo-text">CK</span>
                </div>
                <span class="logo-brand">Café Kopitiam33</span>
            </a>

            <!-- Desktop Menu -->
            <div class="desktop-menu">
                <a href="{{ route('home') }}" class="nav-link" :class="{ 'nav-link-active': activeMenu === 'home' }">Dashboard</a>

                <!-- Dropdown Menu -->
                <div class="dropdown" 
                    x-data="{ menuOpen: false, timeout: null }"
                    @mouseenter="clearTimeout(timeout); menuOpen = true"
                    @mouseleave="timeout = setTimeout(() => { menuOpen = false }, 150)">
                    <button class="dropdown-button" :class="{ 'dropdown-button-active': activeMenu === 'menu' || activeMenu === 'promo' || activeMenu === 'menu-spesial' }">
                        Menu
                        <svg class="dropdown-icon" :class="{ 'rotate': menuOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="dropdown-menu" :class="{ 'show': menuOpen }"
                        @mouseenter="clearTimeout(timeout); menuOpen = true"
                        @mouseleave="timeout = setTimeout(() => { menuOpen = false }, 150)">
                        <a href="{{ route('menu') }}" class="dropdown-item" @click="setActiveMenu('menu')">Semua Menu</a>
                        <a href="{{ route('promo') }}" class="dropdown-item" @click="setActiveMenu('promo')">Promo</a>
                        <a href="{{ route('menu-spesial') }}" class="dropdown-item" @click="setActiveMenu('menu-spesial')">Menu Spesial</a>
                    </div>
                </div>

                <a href="{{ route('reservasi') }}" class="nav-link" :class="{ 'nav-link-active': activeMenu === 'reservasi' }">Reservasi</a>
                <a href="{{ route('gallery') }}" class="nav-link" :class="{ 'nav-link-active': activeMenu === 'gallery' }">Gallery</a>
                <a href="{{ route('about') }}" class="nav-link" :class="{ 'nav-link-active': activeMenu === 'about' }">About</a>
                <a href="{{ route('contact') }}" class="nav-link" :class="{ 'nav-link-active': activeMenu === 'contact' }">Contact</a>

                
                <!-- Profile Dropdown / Auth Buttons -->
                @auth
                <div class="profile-dropdown" x-data="{ open: false }">
                    <button @click="open = !open" class="profile-button">
                        <svg class="profile-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>{{ Auth::user()->name }}</span>
                        <svg class="dropdown-icon" :class="{ 'rotate': open }" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-cloak class="profile-menu">
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="profile-menu-item">📊 Dashboard Admin</a>
                            <a href="{{ route('admin.menu.index') }}" class="profile-menu-item">📋 Kelola Menu</a>
                            <a href="{{ route('admin.reservasi') }}" class="profile-menu-item">📅 Kelola Reservasi</a>
                            <a href="{{ route('admin.pesanan') }}" class="profile-menu-item">📦 Kelola Pesanan</a>
                        @else
                            <a href="{{ route('cart') }}" class="profile-menu-item">🛒 Keranjang Saya</a>
                            <a href="{{ route('orders.history') }}" class="profile-menu-item">📋 Riwayat Pesanan</a>
                            <a href="{{ route('reservasi.history') }}" class="profile-menu-item">📅 Riwayat Reservasi</a>
                            <a href="{{ route('testimonial.my') }}" class="profile-menu-item">💬 Riwayat Testimoni</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="profile-menu-item">🚪 Logout</button>
                        </form>
                    </div>
                </div>
                @else
                <div class="auth-buttons">
                    <a href="{{ route('login') }}" class="btn-login">Login</a>
                    <a href="{{ route('register') }}" class="btn-register">Daftar</a>
                </div>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="mobile-buttons">
                <button class="cart-button" @click="cartOpenMobile = !cartOpenMobile">
                    <svg class="cart-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span x-show="cartTotal > 0" x-cloak class="cart-badge" x-text="cartTotal"></span>
                </button>
                <button class="mobile-menu-btn" @click="toggleMobileMenu">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="mobile-menu" :class="{ 'open': mobileMenuOpen }">
            <div class="mobile-menu-links">
                <a href="{{ route('home') }}" class="mobile-link" :class="{ 'mobile-link-active': activeMenu === 'home' }">Beranda</a>
                
                <div x-data="{ menuOpenMobile: false }">
                    <button @click="menuOpenMobile = !menuOpenMobile" class="mobile-dropdown-btn">
                        <span>Menu</span>
                        <svg class="dropdown-icon" :class="{ 'rotate': menuOpenMobile }" width="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="menuOpenMobile" x-cloak class="mobile-submenu">
                        <a href="{{ route('menu') }}" class="mobile-submenu-link">Semua Menu</a>
                        <a href="{{ route('promo') }}" class="mobile-submenu-link">Promo</a>
                        <a href="{{ route('menu-spesial') }}" class="mobile-submenu-link">Menu Spesial</a>
                    </div>
                </div>
                
                <a href="{{ route('reservasi') }}" class="mobile-link">Reservasi</a>
                <a href="{{ route('gallery') }}" class="mobile-link">Gallery</a>
                <a href="{{ route('about') }}" class="mobile-link">About</a>
                <a href="{{ route('contact') }}" class="mobile-link">Contact</a>

                <!-- 🔥 RIWAYAT PESANAN, RESERVASI, DAN TESTIMONI DI MOBILE 🔥 -->
                @auth
                    @if(Auth::user()->role === 'customer')
                        <a href="{{ route('orders.history') }}" class="mobile-link">📋 Riwayat Pesanan</a>
                        <a href="{{ route('reservasi.history') }}" class="mobile-link">📅 Riwayat Reservasi</a>
                        <a href="{{ route('testimonial.my') }}" class="mobile-link">💬 Riwayat Testimoni</a>
                    @endif
                @endauth
                
                <div class="mobile-auth-section">
                    @auth
                        <div style="padding: 0.5rem 0; font-weight: 600; color: var(--wood);">
                            👤 {{ Auth::user()->name }}
                        </div>
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="mobile-link">📊 Dashboard Admin</a>
                            <a href="{{ route('admin.menu.index') }}" class="mobile-link">📋 Kelola Menu</a>
                            <a href="{{ route('admin.reservasi') }}" class="mobile-link">📅 Kelola Reservasi</a>
                            <a href="{{ route('admin.pesanan') }}" class="mobile-link">📦 Kelola Pesanan</a>
                        @else
                            <a href="{{ route('cart') }}" class="mobile-link">🛒 Keranjang Saya</a>
                            <a href="{{ route('orders.history') }}" class="mobile-link">📋 Riwayat Pesanan</a>
                            <a href="{{ route('reservasi.history') }}" class="mobile-link">📅 Riwayat Reservasi</a>
                            <a href="{{ route('testimonial.my') }}" class="mobile-link">💬 Riwayat Testimoni</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="mobile-link" style="background: none; border: none; cursor: pointer; text-align: left;">🚪 Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="mobile-link">Login</a>
                        <a href="{{ route('register') }}" class="mobile-link">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    function navigationData() {
        return {
            cartItems: [],
            cartTotal: 0,
            cartTotalPrice: 0,
            activeMenu: 'home',
            mobileMenuOpen: false,
            cartOpenMobile: false,
            
            init() {
                this.setActiveFromURL();
                this.loadCart();
                window.addEventListener('cart-updated', () => this.loadCart());
                window.addEventListener('add-to-cart', (e) => this.addToCart(e.detail));
            },
            
            setActiveFromURL() {
                const path = window.location.pathname;
                if (path === '/' || path === '/home') this.activeMenu = 'home';
                else if (path === '/menu') this.activeMenu = 'menu';
                else if (path === '/promo') this.activeMenu = 'promo';
                else if (path === '/menu-spesial') this.activeMenu = 'menu-spesial';
                else if (path === '/reservasi') this.activeMenu = 'reservasi';
                else if (path === '/gallery') this.activeMenu = 'gallery';
                else if (path === '/about') this.activeMenu = 'about';
                else if (path === '/contact') this.activeMenu = 'contact';
                else if (path === '/cart') this.activeMenu = 'cart';
                else if (path === '/order/history') this.activeMenu = 'order-history';
                else if (path === '/reservasi/history') this.activeMenu = 'reservasi-history';
                else if (path === '/testimonial/my') this.activeMenu = 'testimonial';
            },
            
            setActiveMenu(menu) {
                this.activeMenu = menu;
            },
            
            toggleMobileMenu() {
                this.mobileMenuOpen = !this.mobileMenuOpen;
            },
            
            loadCart() {
                const saved = localStorage.getItem('kopitiam_cart');
                if (saved) {
                    try {
                        this.cartItems = JSON.parse(saved);
                        this.cartTotal = this.cartItems.reduce((sum, item) => sum + item.quantity, 0);
                        this.cartTotalPrice = this.cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                    } catch(e) {
                        this.cartItems = [];
                        this.cartTotal = 0;
                        this.cartTotalPrice = 0;
                    }
                } else {
                    this.cartItems = [];
                    this.cartTotal = 0;
                    this.cartTotalPrice = 0;
                }
            },
            
            addToCart(product) {
                const existing = this.cartItems.find(item => item.id === product.id);
                if (existing) {
                    existing.quantity += 1;
                } else {
                    this.cartItems.push({ ...product, quantity: 1 });
                }
                this.saveCart();
                this.showNotification(`${product.name} ditambahkan ke keranjang! 🛒`);
            },
            
            updateQuantity(id, delta) {
                const index = this.cartItems.findIndex(item => item.id === id);
                if (index !== -1) {
                    const newQty = this.cartItems[index].quantity + delta;
                    if (newQty <= 0) {
                        this.cartItems.splice(index, 1);
                        this.showNotification('Item dihapus dari keranjang');
                    } else {
                        this.cartItems[index].quantity = newQty;
                    }
                    this.saveCart();
                }
            },
            
            removeItem(id) {
                const item = this.cartItems.find(item => item.id === id);
                this.cartItems = this.cartItems.filter(item => item.id !== id);
                this.saveCart();
                if (item) {
                    this.showNotification(`${item.name} dihapus dari keranjang`);
                }
            },
            
            saveCart() {
                localStorage.setItem('kopitiam_cart', JSON.stringify(this.cartItems));
                this.cartTotal = this.cartItems.reduce((sum, item) => sum + item.quantity, 0);
                this.cartTotalPrice = this.cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                window.dispatchEvent(new CustomEvent('cart-updated'));
            },
            
            checkout() {
                if (this.cartItems.length === 0) {
                    this.showNotification('Keranjang kosong! Yuk mulai pesan 😊');
                    return;
                }
                window.location.href = '{{ route("cart") }}';
            },
            
            showNotification(message) {
                const existingNotif = document.querySelector('.cart-notification');
                if (existingNotif) {
                    existingNotif.remove();
                }
                
                const notification = document.createElement('div');
                notification.className = 'cart-notification';
                notification.textContent = message;
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.style.animation = 'slideOut 0.3s ease';
                    setTimeout(() => {
                        if (notification.parentNode) {
                            notification.remove();
                        }
                    }, 300);
                }, 2500);
            },
            
            formatPrice(price) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(price);
            }
        }
    }
    
    document.addEventListener('alpine:init', () => {
        Alpine.data('navigationData', navigationData);
    });
</script>

<!-- Floating Testimoni Button -->
@auth
<div x-data="testimonialWidget()" x-init="init" class="testimonial-floating">
    <button @click="openModal = true" class="testimonial-btn">
        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
        </svg>
        <span>Testimoni</span>
    </button>
    
    <div x-show="openModal" x-cloak class="testimonial-modal" @click.away="openModal = false">
        <div class="testimonial-modal-content">
            <div class="testimonial-modal-header">
                <h3>💬 Berikan Testimoni</h3>
                <button @click="openModal = false" class="close-btn">&times;</button>
            </div>
            <div class="testimonial-modal-body">
                <div class="rating-input">
                    <label>Rating Anda</label>
                    <div class="stars">
                        <template x-for="star in 5" :key="star">
                            <span @click="rating = star" class="star" :class="{ 'active': star <= rating }">★</span>
                        </template>
                    </div>
                </div>
                <div class="message-input">
                    <label>Testimoni Anda</label>
                    <textarea x-model="message" rows="4" placeholder="Tulis pengalaman Anda di Café Kopitiam33..."></textarea>
                </div>
                <div class="char-count" x-text="message.length + '/500 karakter'"></div>
                <div class="testimonial-actions">
                    <button @click="submitTestimonial" :disabled="loading" class="btn-submit">
                        <span x-show="loading">⏳ Mengirim...</span>
                        <span x-show="!loading">✉️ Kirim Testimoni</span>
                    </button>
                    <button @click="openModal = false" class="btn-cancel">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .testimonial-floating {
        position: fixed;
        bottom: 30px;
        left: 30px;
        z-index: 999;
    }
    .testimonial-btn {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        border-radius: 50px;
        padding: 12px 20px;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        font-size: 14px;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        transition: all 0.3s ease;
    }
    .testimonial-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }
    .testimonial-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }
    .testimonial-modal-content {
        background: white;
        border-radius: 1rem;
        max-width: 450px;
        width: 90%;
        animation: modalPop 0.3s ease;
    }
    @keyframes modalPop {
        from { transform: scale(0.9); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    .testimonial-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f3f4f6;
    }
    .testimonial-modal-header h3 {
        font-family: 'Playfair Display', serif;
        color: var(--wood);
        margin: 0;
    }
    .close-btn {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #6b7280;
    }
    .testimonial-modal-body {
        padding: 1.5rem;
    }
    .rating-input {
        margin-bottom: 1rem;
    }
    .rating-input label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--wood);
        margin-bottom: 0.5rem;
    }
    .stars {
        display: flex;
        gap: 0.25rem;
    }
    .star {
        font-size: 1.5rem;
        color: #d1d5db;
        cursor: pointer;
        transition: color 0.2s;
    }
    .star.active {
        color: #fbbf24;
    }
    .star:hover {
        transform: scale(1.1);
    }
    .message-input {
        margin-bottom: 0.5rem;
    }
    .message-input label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--wood);
        margin-bottom: 0.5rem;
    }
    .message-input textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        font-family: 'Poppins', sans-serif;
        resize: vertical;
    }
    .message-input textarea:focus {
        outline: none;
        border-color: #10b981;
    }
    .char-count {
        text-align: right;
        font-size: 0.7rem;
        color: #6b7280;
        margin-bottom: 1rem;
    }
    .testimonial-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1rem;
    }
    .btn-submit {
        flex: 1;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 0.75rem;
        border: none;
        border-radius: 0.5rem;
        cursor: pointer;
        font-weight: 500;
    }
    .btn-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    .btn-cancel {
        flex: 1;
        background: #e5e7eb;
        color: #374151;
        padding: 0.75rem;
        border: none;
        border-radius: 0.5rem;
        cursor: pointer;
        font-weight: 500;
    }
</style>

<script>
    function testimonialWidget() {
        return {
            openModal: false,
            rating: 5,
            message: '',
            loading: false,
            
            init() {},
            
            submitTestimonial() {
                if (this.message.trim().length < 10) {
                    alert('Testimoni minimal 10 karakter');
                    return;
                }
                if (this.message.length > 500) {
                    alert('Testimoni maksimal 500 karakter');
                    return;
                }
                
                this.loading = true;
                
                fetch('/testimonial/store', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        rating: this.rating,
                        message: this.message
                    })
                })
                .then(response => response.json())
                .then(data => {
                    this.loading = false;
                    if (data.success) {
                        alert('Terima kasih! Testimoni Anda telah terkirim.');
                        this.openModal = false;
                        this.message = '';
                        this.rating = 5;
                    } else {
                        alert(data.message || 'Gagal mengirim testimoni');
                    }
                })
                .catch(error => {
                    this.loading = false;
                    console.error('Error:', error);
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                });
            }
        }
    }
    
    document.addEventListener('alpine:init', () => {
        Alpine.data('testimonialWidget', testimonialWidget);
    });
</script>
@endauth

</body>
</html>