<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Café Kopitiam33</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
<link rel="stylesheet" href="{{ asset('css/layouts/navbar.css') }}">
</head>
<body>

<nav class="nav-container" x-data="navigationData()" x-init="init">
    <div class="nav-inner">
        <div class="nav-content">
            <!-- Logo -->
            <a href="{{ route('dashboard') }}" class="logo-link">
                <div class="logo-circle">
                    <span class="logo-text">CK</span>
                </div>
                <span class="logo-brand" style="color: #A67B5B !important; display: block !important; opacity: 1 !important; visibility: visible !important;">Café Kopitiam33</span>
            </a>

            <!-- Desktop Menu -->
            <div class="desktop-menu">
                <a href="{{ route('dashboard') }}" class="nav-link" :class="{ 'nav-link-active': activeMenu === 'dashboard' }">Dashboard</a>

                <!-- Dropdown Menu -->
                <div class="dropdown" 
                    x-data="{ menuOpen: false, timeout: null }"
                    @mouseenter="clearTimeout(timeout); menuOpen = true"
                    @mouseleave="timeout = setTimeout(() => { menuOpen = false }, 150)">
                    <button class="dropdown-button" :class="{ 'dropdown-button-active': activeMenu === 'menu' || activeMenu === 'menu-spesial' }">
                        Menu
                        <svg class="dropdown-icon" :class="{ 'rotate': menuOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="dropdown-menu" :class="{ 'show': menuOpen }"
                        @mouseenter="clearTimeout(timeout); menuOpen = true"
                        @mouseleave="timeout = setTimeout(() => { menuOpen = false }, 150)">
                        <a href="{{ route('menu') }}" class="dropdown-item" @click="setActiveMenu('menu')">Semua Menu</a>
                        <a href="{{ route('menu-spesial') }}" class="dropdown-item" @click="setActiveMenu('menu-spesial')">Menu Spesial</a>
                    </div>
                </div>

                <a href="{{ route('reservasi') }}" class="nav-link" :class="{ 'nav-link-active': activeMenu === 'reservasi' }">Reservasi</a>
                <a href="{{ route('gallery') }}" class="nav-link" :class="{ 'nav-link-active': activeMenu === 'gallery' }">Gallery</a>
                <a href="{{ route('about') }}" class="nav-link" :class="{ 'nav-link-active': activeMenu === 'about' }">About</a>
                <a href="{{ route('contact') }}" class="nav-link" :class="{ 'nav-link-active': activeMenu === 'contact' }">Contact</a>

                <!-- DESKTOP CART BUTTON - INTEGRATED -->
                <a href="{{ route('cart') }}" class="cart-button desktop-cart-btn" style="position: relative; text-decoration: none;">
                    <svg class="cart-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span x-show="cartTotal > 0" x-cloak class="cart-badge desktop-cart-badge" x-text="cartTotal"></span>
                </a>

                <!-- Notification Bell - DESKTOP ONLY -->
                @auth
                <div class="notification-bell desktop-notification" x-data="desktopNotificationData()" x-init="initDesktopNotification()">
                    <button @click="toggleDropdown" class="notification-btn">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span x-show="desktopUnreadCount > 0" x-text="desktopUnreadCount" class="notification-badge"></span>
                    </button>
                    
                    <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-cloak class="notification-dropdown">
                        <div class="notification-header">
                            <h3><span>🔔</span> Notifikasi</h3>
                            <p>Pemberitahuan pesanan dan reservasi</p>
                        </div>
                        <div class="notification-list">
                            <template x-for="notif in desktopNotifications" :key="notif.id">
                                <div class="notification-item" :class="{ 'unread': !notif.is_read }" @click="handleNotificationClick(notif.id)">
                                    <div class="flex-start">
                                        <div class="notification-icon" :class="notif.type">
                                            <span x-text="notif.type === 'order' ? '📦' : '📅'"></span>
                                        </div>
                                        <div class="notification-content">
                                            <div class="notification-title" x-text="notif.title"></div>
                                            <div class="notification-message" x-text="notif.message.length > 45 ? notif.message.substring(0, 45) + '...' : notif.message"></div>
                                            <div class="notification-time" x-text="formatTime(notif.created_at)"></div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <div x-show="desktopNotifications.length === 0" class="empty-notification">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                <p>Tidak ada notifikasi baru</p>
                            </div>
                        </div>
                        <div class="notification-footer">
                            <a href="{{ route('notifications.index') }}">📬 Lihat semua notifikasi →</a>
                        </div>
                    </div>
                </div>
                @endauth

                <!-- Profile Dropdown / Auth Buttons -->
                @auth
                <div class="profile-dropdown" x-data="{ open: false }">
                    <button @click="open = !open" class="profile-button">
                        <svg class="profile-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span class="profile-name">{{ Auth::user()->name }}</span>
                        <svg class="dropdown-icon" :class="{ 'rotate': open }" width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

            <!-- Mobile Buttons (Cart + Notification + Menu) -->
            <div class="mobile-buttons">
                <!-- NOTIFICATION BUTTON - MOBILE -->
                @auth
                <div class="notification-bell mobile-notification" x-data="mobileNotificationData()" x-init="initMobileNotification()">
                    <button @click="toggleMobileDropdown" class="mobile-notification-btn">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span x-show="mobileUnreadCount > 0" x-text="mobileUnreadCount" class="mobile-notification-badge"></span>
                    </button>
                    
                    <div x-show="mobileDropdownOpen" @click.away="mobileDropdownOpen = false" x-cloak class="mobile-notification-dropdown">
                        <div class="mobile-notification-header">
                            <h3><span>🔔</span> Notifikasi</h3>
                            <button @click="mobileDropdownOpen = false" class="mobile-notification-close">✕</button>
                        </div>
                        <div class="mobile-notification-list">
                            <template x-for="notif in mobileNotifications" :key="notif.id">
                                <div class="mobile-notification-item" :class="{ 'unread': !notif.is_read }" @click="handleMobileNotificationClick(notif.id)">
                                    <div class="mobile-notification-text">
                                        <div class="mobile-notification-title" x-text="notif.title"></div>
                                        <div class="mobile-notification-message" x-text="notif.message.length > 70 ? notif.message.substring(0, 70) + '...' : notif.message"></div>
                                        <div class="mobile-notification-time" x-text="formatMobileTime(notif.created_at)"></div>
                                    </div>
                                </div>
                            </template>
                            <div x-show="mobileNotifications.length === 0" class="empty-notification">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                <p>Tidak ada notifikasi baru</p>
                            </div>
                        </div>
                        <div class="mobile-notification-footer">
                            <a href="{{ route('notifications.index') }}" @click="mobileDropdownOpen = false">📬 Lihat semua notifikasi →</a>
                        </div>
                    </div>
                </div>
                @endauth

                <!-- MOBILE CART BUTTON (tetap seperti asli) -->
                <a href="{{ route('cart') }}" class="cart-button">
                    <svg class="cart-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span x-show="cartTotal > 0" x-cloak class="cart-badge" x-text="cartTotal"></span>
                </a>
                
                <!-- Menu Toggle Button -->
                <button class="mobile-menu-btn" @click="toggleMobileMenu">
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu (Sidebar) -->
        <div class="mobile-menu" :class="{ 'open': mobileMenuOpen }">
            <div class="mobile-menu-links">
                <a href="{{ route('dashboard') }}" class="mobile-link" :class="{ 'mobile-link-active': activeMenu === 'dashboard' }" @click="toggleMobileMenu">🏠 Beranda</a>
                
                <div x-data="{ menuOpenMobile: false }">
                    <button @click="menuOpenMobile = !menuOpenMobile" class="mobile-dropdown-btn">
                        <span>🍽️ Menu</span>
                        <svg class="dropdown-icon" :class="{ 'rotate': menuOpenMobile }" width="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="menuOpenMobile" x-cloak class="mobile-submenu">
                        <a href="{{ route('menu') }}" class="mobile-submenu-link" @click="toggleMobileMenu">📋 Semua Menu</a>
                        <a href="{{ route('menu-spesial') }}" class="mobile-submenu-link" @click="toggleMobileMenu">⭐ Menu Spesial</a>
                    </div>
                </div>
                
                <a href="{{ route('reservasi') }}" class="mobile-link" @click="toggleMobileMenu">📅 Reservasi</a>
                <a href="{{ route('gallery') }}" class="mobile-link" @click="toggleMobileMenu">🖼️ Gallery</a>
                <a href="{{ route('about') }}" class="mobile-link" @click="toggleMobileMenu">ℹ️ About</a>
                <a href="{{ route('contact') }}" class="mobile-link" @click="toggleMobileMenu">📞 Contact</a>

                @auth
                    @if(Auth::user()->role === 'customer')
                        <a href="{{ route('cart') }}" class="mobile-link" @click="toggleMobileMenu">🛒 Keranjang Saya</a>
                        <a href="{{ route('orders.history') }}" class="mobile-link" @click="toggleMobileMenu">📋 Riwayat Pesanan</a>
                        <a href="{{ route('reservasi.history') }}" class="mobile-link" @click="toggleMobileMenu">📅 Riwayat Reservasi</a>
                        <a href="{{ route('testimonial.my') }}" class="mobile-link" @click="toggleMobileMenu">💬 Riwayat Testimoni</a>
                    @endif
                @endauth
                
                <div class="mobile-auth-section">
                    @auth
                        <div style="padding: 0.3rem 0; font-weight: 600; color: var(--wood); display: flex; align-items: center; gap: 8px;">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>{{ Auth::user()->name }}</span>
                        </div>
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="mobile-link" @click="toggleMobileMenu">📊 Dashboard Admin</a>
                            <a href="{{ route('admin.menu.index') }}" class="mobile-link" @click="toggleMobileMenu">📋 Kelola Menu</a>
                            <a href="{{ route('admin.reservasi') }}" class="mobile-link" @click="toggleMobileMenu">📅 Kelola Reservasi</a>
                            <a href="{{ route('admin.pesanan') }}" class="mobile-link" @click="toggleMobileMenu">📦 Kelola Pesanan</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="mobile-link" style="background: none; border: none; cursor: pointer; text-align: left; width: 100%;">🚪 Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="mobile-link" @click="toggleMobileMenu">🔐 Login</a>
                        <a href="{{ route('register') }}" class="mobile-link" @click="toggleMobileMenu">📝 Daftar</a>
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
            activeMenu: 'dashboard',
            mobileMenuOpen: false,
            
            init() {
                this.setActiveFromURL();
                
                @auth
                    // Sync guest cart to server if exists
                    const saved = localStorage.getItem('kopitiam_cart');
                    if (saved) {
                        try {
                            const localCart = JSON.parse(saved);
                            if (localCart && localCart.length > 0) {
                                this.syncLocalCartToServer(localCart);
                                return;
                            }
                        } catch(e) {}
                    }
                @endauth
                
                this.loadCart();
                window.addEventListener('cart-updated', () => this.loadCart());
                window.addEventListener('add-to-cart', (e) => this.addToCart(e.detail));
                
                window.addEventListener('resize', () => {
                    if (window.innerWidth > 768 && this.mobileMenuOpen) {
                        this.mobileMenuOpen = false;
                        document.body.style.overflow = '';
                    }
                });
            },
            
            syncLocalCartToServer(localCart) {
                let promises = localCart.map(item => {
                    return fetch('{{ route("cart.add") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            item_id: item.id,
                            item_type: item.type,
                            name: item.name,
                            price: item.price,
                            quantity: item.quantity,
                            image: item.image,
                            is_menu_spesial: item.is_menu_spesial
                        })
                    });
                });
                
                Promise.all(promises)
                    .then(() => {
                        localStorage.removeItem('kopitiam_cart');
                        this.loadCart();
                    })
                    .catch(error => {
                        console.error('Error syncing cart:', error);
                        localStorage.removeItem('kopitiam_cart');
                        this.loadCart();
                    });
            },
            
            setActiveFromURL() {
                const path = window.location.pathname;
                if (path === '/' || path === '/dashboard') this.activeMenu = 'dashboard';
                else if (path === '/menu') this.activeMenu = 'menu';
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
                if (this.mobileMenuOpen) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            },
            
            loadCart() {
                @auth
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
                            this.cartItems = data.cart || [];
                        } else {
                            this.cartItems = [];
                        }
                        this.updateCartCount();
                    })
                    .catch(error => {
                        console.error('Error loading cart:', error);
                        this.cartItems = [];
                        this.updateCartCount();
                    });
                @else
                    const saved = localStorage.getItem('kopitiam_cart');
                    if (saved) {
                        try {
                            this.cartItems = JSON.parse(saved);
                        } catch(e) {
                            this.cartItems = [];
                        }
                    } else {
                        this.cartItems = [];
                    }
                    this.updateCartCount();
                @endauth
            },
            
            updateCartCount() {
                this.cartTotal = this.cartItems.reduce((sum, item) => sum + item.quantity, 0);
                this.cartTotalPrice = this.cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
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
                if (existingNotif) existingNotif.remove();
                
                const notification = document.createElement('div');
                notification.className = 'cart-notification';
                notification.textContent = message;
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.style.animation = 'slideOut 0.3s ease';
                    setTimeout(() => {
                        if (notification.parentNode) notification.remove();
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
    
    // Desktop Notification Data
    function desktopNotificationData() {
        return {
            dropdownOpen: false,
            desktopUnreadCount: 0,
            desktopNotifications: [],
            intervalId: null,
            
            initDesktopNotification() {
                this.fetchDesktopNotifications();
                this.intervalId = setInterval(() => {
                    this.fetchDesktopNotifications();
                }, 30000);
            },
            
            toggleDropdown() {
                this.dropdownOpen = !this.dropdownOpen;
                if (this.dropdownOpen) {
                    this.fetchDesktopNotifications();
                }
            },
            
            fetchDesktopNotifications() {
                fetch('{{ route("notifications.latest") }}')
                    .then(res => res.json())
                    .then(data => {
                        this.desktopNotifications = (data.notifications || []).filter(notif => !notif.is_read);
                        this.desktopUnreadCount = data.unread_count || 0;
                    })
                    .catch(err => console.error('Error fetching desktop notifications:', err));
            },
            
            handleNotificationClick(notifId) {
                fetch(`/notifications/${notifId}/read`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(res => res.json())
                .then(() => {
                    window.location.href = '{{ route("notifications.index") }}';
                })
                .catch(err => console.error('Error:', err));
            },
            
            formatTime(dateString) {
                const date = new Date(dateString);
                const now = new Date();
                const diffMs = now - date;
                const diffMins = Math.floor(diffMs / 60000);
                const diffHours = Math.floor(diffMs / 3600000);
                const diffDays = Math.floor(diffMs / 86400000);
                
                if (diffMins < 1) return 'Baru saja';
                if (diffMins < 60) return `${diffMins} menit lalu`;
                if (diffHours < 24) return `${diffHours} jam lalu`;
                if (diffDays === 1) return 'Kemarin';
                if (diffDays < 7) return `${diffDays} hari lalu`;
                return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
            }
        }
    }
    
    // Mobile Notification Data
    function mobileNotificationData() {
        return {
            mobileDropdownOpen: false,
            mobileUnreadCount: 0,
            mobileNotifications: [],
            mobileIntervalId: null,
            
            initMobileNotification() {
                this.fetchMobileNotifications();
                this.mobileIntervalId = setInterval(() => {
                    this.fetchMobileNotifications();
                }, 30000);
                
                window.mobileNotifData = this;
            },
            
            toggleMobileDropdown() {
                this.mobileDropdownOpen = !this.mobileDropdownOpen;
                if (this.mobileDropdownOpen) {
                    this.fetchMobileNotifications();
                }
            },
            
            fetchMobileNotifications() {
                fetch('{{ route("notifications.latest") }}')
                    .then(res => res.json())
                    .then(data => {
                        this.mobileNotifications = (data.notifications || []).filter(notif => !notif.is_read);
                        this.mobileUnreadCount = data.unread_count || 0;
                    })
                    .catch(err => console.error('Error fetching mobile notifications:', err));
            },
            
            handleMobileNotificationClick(notifId) {
                fetch(`/notifications/${notifId}/read`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(res => res.json())
                .then(() => {
                    window.location.href = '{{ route("notifications.index") }}';
                })
                .catch(err => console.error('Error:', err));
            },
            
            formatMobileTime(dateString) {
                const date = new Date(dateString);
                const now = new Date();
                const diffMs = now - date;
                const diffMins = Math.floor(diffMs / 60000);
                const diffHours = Math.floor(diffMs / 3600000);
                const diffDays = Math.floor(diffMs / 86400000);
                
                if (diffMins < 1) return 'Baru saja';
                if (diffMins < 60) return `${diffMins} menit lalu`;
                if (diffHours < 24) return `${diffHours} jam lalu`;
                if (diffDays === 1) return 'Kemarin';
                if (diffDays < 7) return `${diffDays} hari lalu`;
                return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
            }
        }
    }
    
    document.addEventListener('alpine:init', () => {
        Alpine.data('navigationData', navigationData);
        Alpine.data('desktopNotificationData', desktopNotificationData);
        Alpine.data('mobileNotificationData', mobileNotificationData);
    });
    
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            if (window.Alpine && window.Alpine.store) {
                // Additional setup if needed
            }
        }, 100);
    });
</script>

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
            background: var(--cream);
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }
        
        /* Navbar Styles */
        .nav-container {
            background: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
            width: 100%;
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
            flex-shrink: 0;
        }
        
        .logo-circle {
            width: 36px;
            height: 36px;
            background: var(--sage);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .logo-text {
            color: white;
            font-weight: bold;
            font-size: 1rem;
        }
        
        .logo-brand {
            color: var(--wood);
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            font-weight: 600;
        }
        
        @media (min-width: 768px) {
            .logo-circle {
                width: 40px;
                height: 40px;
            }
            .logo-text {
                font-size: 1.25rem;
            }
            .logo-brand {
                font-size: 1.5rem;
            }
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
            font-size: 0.9rem;
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
            font-size: 0.9rem;
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
            min-width: 160px;
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
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
            color: #374151;
            text-decoration: none;
            transition: all 0.2s;
            white-space: nowrap;
        }
        
        .dropdown-item:hover {
            background: var(--cream);
            color: var(--sage);
        }
        
        /* Desktop Cart Styles (menambahkan style khusus desktop agar konsisten) */
        .desktop-cart-btn {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.4rem;
            border-radius: 50%;
            transition: background 0.2s ease;
            color: var(--wood);
        }
        
        .desktop-cart-btn:hover {
            background: rgba(139, 168, 136, 0.1);
            color: var(--accent);
        }
        
        .desktop-cart-btn .cart-icon {
            width: 20px;
            height: 20px;
        }
        
        .desktop-cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--accent);
            color: white;
            font-size: 0.6rem;
            font-weight: bold;
            border-radius: 50%;
            min-width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 3px;
        }
        
        /* Cart Styles (umum) */
        .cart-button {
            position: relative;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--wood);
            padding: 0.5rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        
        .cart-icon {
            width: 22px;
            height: 22px;
        }
        
        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--accent);
            color: white;
            font-size: 0.6rem;
            font-weight: bold;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* ==================== NOTIFICATION BELL STYLES - DESKTOP ==================== */
        .notification-bell {
            position: relative;
        }
        
        .notification-btn {
            position: relative;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.4rem;
            border-radius: 50%;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .notification-btn:hover {
            background: rgba(139, 168, 136, 0.1);
        }
        
        .notification-btn svg {
            width: 20px;
            height: 20px;
            color: var(--wood);
            transition: color 0.2s ease;
        }
        
        .notification-btn:hover svg {
            color: var(--accent);
        }
        
        .notification-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: var(--accent);
            color: white;
            font-size: 0.55rem;
            font-weight: 600;
            border-radius: 50%;
            min-width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 3px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
        
        .notification-dropdown {
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            width: 310px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px -8px rgba(0, 0, 0, 0.15);
            z-index: 9999;
            overflow: hidden;
            border: 1px solid rgba(139, 168, 136, 0.15);
            animation: dropdownFade 0.2s ease;
        }
        
        @keyframes dropdownFade {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .notification-header {
            padding: 0.7rem 1rem;
            background: linear-gradient(135deg, var(--sage) 0%, var(--wood) 100%);
            color: white;
        }
        
        .notification-header h3 {
            font-size: 0.8rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }
        
        .notification-header p {
            font-size: 0.6rem;
            opacity: 0.85;
            margin-top: 0.2rem;
            margin-bottom: 0;
        }
        
        .notification-list {
            max-height: 340px;
            overflow-y: auto;
        }
        
        .notification-item {
            padding: 0.65rem 1rem;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .notification-item:hover {
            background: var(--cream);
        }
        
        .notification-item.unread {
            background: #FFF8F0;
            border-left: 3px solid var(--accent);
        }
        
        .notification-icon {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            flex-shrink: 0;
        }
        
        .notification-icon.order {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        }
        
        .notification-icon.reservation {
            background: linear-gradient(135deg, var(--sage) 0%, var(--wood) 100%);
        }
        
        .notification-content {
            flex: 1;
            min-width: 0;
        }
        
        .notification-title {
            font-size: 0.78rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.15rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .notification-message {
            font-size: 0.68rem;
            color: #6b7280;
            line-height: 1.4;
            margin-bottom: 0.2rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .notification-time {
            font-size: 0.58rem;
            color: #9ca3af;
            display: flex;
            align-items: center;
            gap: 0.2rem;
        }
        
        .notification-time::before {
            content: '🕐';
            font-size: 0.55rem;
        }
        
        .notification-footer {
            padding: 0.55rem 1rem;
            background: #fafafa;
            border-top: 1px solid #f0f0f0;
            text-align: center;
        }
        
        .notification-footer a {
            color: var(--sage);
            text-decoration: none;
            font-size: 0.68rem;
            font-weight: 500;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .notification-footer a:hover {
            color: var(--accent);
        }
        
        .empty-notification {
            padding: 1.5rem;
            text-align: center;
        }
        
        .empty-notification svg {
            width: 38px;
            height: 38px;
            margin-bottom: 0.5rem;
            opacity: 0.4;
        }
        
        .empty-notification p {
            font-size: 0.7rem;
            color: #9ca3af;
        }
        
        .flex-start {
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
        }
        
        /* ==================== MOBILE NOTIFICATION BUTTON ==================== */
        .mobile-notification-btn {
            position: relative;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--wood);
        }
        
        .mobile-notification-btn svg {
            width: 22px;
            height: 22px;
        }
        
        .mobile-notification-badge {
            position: absolute;
            top: -3px;
            right: -3px;
            background: var(--accent);
            color: white;
            font-size: 0.55rem;
            font-weight: 600;
            border-radius: 50%;
            min-width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 3px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
        
        .mobile-notification-dropdown {
            position: fixed;
            top: auto;
            bottom: 20px;
            left: 20px;
            right: 20px;
            width: auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px -8px rgba(0, 0, 0, 0.25);
            z-index: 9999;
            overflow: hidden;
            border: 1px solid rgba(139, 168, 136, 0.15);
            animation: mobileDropdownFade 0.2s ease;
        }
        
        @keyframes mobileDropdownFade {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .mobile-notification-header {
            padding: 0.7rem 1rem;
            background: linear-gradient(135deg, var(--sage) 0%, var(--wood) 100%);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .mobile-notification-header h3 {
            font-size: 0.8rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }
        
        .mobile-notification-close {
            background: none;
            border: none;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 0.2rem;
        }
        
        .mobile-notification-list {
            max-height: 340px;
            overflow-y: auto;
        }
        
        .mobile-notification-item {
            padding: 0.65rem 1rem;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .mobile-notification-item.unread {
            background: #FFF8F0;
            border-left: 3px solid var(--accent);
        }
        
        .mobile-notification-item:active {
            background: var(--cream);
        }
        
        .mobile-notification-text {
            flex: 1;
        }
        
        .mobile-notification-title {
            font-size: 0.75rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.2rem;
        }
        
        .mobile-notification-message {
            font-size: 0.68rem;
            color: #6b7280;
            line-height: 1.4;
            margin-bottom: 0.2rem;
        }
        
        .mobile-notification-time {
            font-size: 0.58rem;
            color: #9ca3af;
        }
        
        .mobile-notification-footer {
            padding: 0.55rem 1rem;
            background: #fafafa;
            border-top: 1px solid #f0f0f0;
            text-align: center;
        }
        
        .mobile-notification-footer a {
            color: var(--sage);
            text-decoration: none;
            font-size: 0.68rem;
            font-weight: 500;
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
            font-size: 0.85rem;
            font-weight: 500;
            transition: color 0.2s;
        }
        
        .profile-button:hover {
            color: var(--sage);
        }
        
        .profile-icon {
            width: 18px;
            height: 18px;
        }
        
        .profile-name {
            max-width: 120px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        @media (max-width: 1024px) {
            .profile-name {
                display: none;
            }
        }
        
        .profile-menu {
            position: absolute;
            right: 0;
            top: calc(100% + 5px);
            min-width: 220px;
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
            padding: 0.5rem 1rem;
            color: #374151;
            text-decoration: none;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 0.8rem;
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
            gap: 0.5rem;
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
            padding: 0.5rem;
        }
        
        .mobile-menu {
            display: none;
            padding: 1rem;
            border-top: 1px solid #e5e7eb;
            background: white;
            max-height: calc(100vh - 64px);
            overflow-y: auto;
        }
        
        .mobile-menu.open {
            display: block;
        }
        
        .mobile-menu-links {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
        }
        
        .mobile-link {
            text-decoration: none;
            color: var(--wood);
            font-size: 0.9rem;
            padding: 0.3rem 0;
            display: block;
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
            font-size: 0.9rem;
            padding: 0.3rem 0;
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
            font-size: 0.85rem;
            padding: 0.2rem 0;
            display: block;
        }
        
        .mobile-auth-section {
            padding-top: 0.8rem;
            margin-top: 0.5rem;
            border-top: 1px solid #e5e7eb;
        }
        
        /* Auth Buttons */
        .auth-buttons {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-login {
            background: transparent;
            border: 1px solid var(--sage);
            color: var(--sage);
            padding: 0.3rem 0.8rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-size: 0.8rem;
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
            padding: 0.3rem 0.8rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .btn-register:hover {
            background: #c0392b;
        }
        
        /* Toast Notification */
        .cart-notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--sage);
            color: white;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 13px;
            z-index: 9999;
            animation: slideIn 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            max-width: calc(100vw - 40px);
            white-space: nowrap;
        }
        
        @media (max-width: 480px) {
            .cart-notification {
                white-space: normal;
                font-size: 12px;
                bottom: 15px;
                right: 15px;
                left: 15px;
                text-align: center;
            }
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
        
        /* Responsive Logo */
        @media (max-width: 480px) {
            .logo-brand {
                display: block;
                font-size: 0.9rem;
                font-weight: 700;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                max-width: 120px;
            }
        }
</style>

</body>
</html>