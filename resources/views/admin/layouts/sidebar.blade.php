{{-- resources/views/layouts/sidebar.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - @yield('title', 'Café Kopitiam33')</title>
    
@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/layouts/sidebar.css') }}">
@endpush
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('styles')
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <div class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-header">
                <div class="flex-between">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-logo" style="flex:1;">
                        <div class="sidebar-logo-circle">
                            <span class="sidebar-logo-text">CK</span>
                        </div>
                        <span class="sidebar-brand">Admin Kopitiam33</span>
                    </a>
                    
                    <!-- NOTIFICATION BELL -->
                    <div class="admin-notification-bell" x-data="adminNotificationData()" x-init="initAdminNotification()">
                        <button @click="toggleDropdown" class="admin-notification-btn" title="Notifikasi">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <span x-show="totalUnread > 0" x-text="totalUnread" class="admin-notification-badge"></span>
                        </button>
                        
                        <!-- Dropdown muncul di sebelah kanan -->
                        <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-cloak class="admin-notification-dropdown" id="notificationDropdown">
                            <div class="admin-notification-header">
                                <h4>
                                    <span>🔔</span> Notifikasi
                                </h4>
                                <p>Pemberitahuan pesanan dan reservasi</p>
                            </div>
                            
                            <div class="admin-notification-list">
                                <!-- Pesanan Baru -->
                                <div class="admin-notification-item" :class="{ 'unread': newOrders > 0 }" @click="goToOrders()">
                                    <div class="admin-notification-icon order">
                                        <span>📦</span>
                                    </div>
                                    <div class="admin-notification-content">
                                        <div class="admin-notification-title">Pesanan Baru</div>
                                        <div class="admin-notification-message">
                                            <span x-text="newOrders > 0 ? newOrders + ' pesanan menunggu diproses' : 'Tidak ada pesanan baru'"></span>
                                        </div>
                                        <div class="admin-notification-time" x-show="newOrders > 0">Perlu segera diproses</div>
                                    </div>
                                    <div class="admin-notification-count" x-show="newOrders > 0" x-text="newOrders"></div>
                                </div>
                                
                                <!-- Reservasi Baru -->
                                <div class="admin-notification-item" :class="{ 'unread': newReservations > 0 }" @click="goToReservations()">
                                    <div class="admin-notification-icon reservation">
                                        <span>📅</span>
                                    </div>
                                    <div class="admin-notification-content">
                                        <div class="admin-notification-title">Reservasi Baru</div>
                                        <div class="admin-notification-message">
                                            <span x-text="newReservations > 0 ? newReservations + ' reservasi menunggu meja/konfirmasi' : 'Tidak ada reservasi baru'"></span>
                                        </div>
                                    </div>
                                    <div class="admin-notification-count" x-show="newReservations > 0" x-text="newReservations"></div>
                                </div>
                                
                                <!-- Reservasi Menunggu Konfirmasi (Sudah Pilih Meja) -->
                                <div class="admin-notification-item" :class="{ 'unread': repliedReservations > 0 }" @click="goToReservations()" x-show="repliedReservations > 0">
                                    <div class="admin-notification-icon reservation" style="background: linear-gradient(135deg, #10b981, #059669);">
                                        <span>💬</span>
                                    </div>
                                    <div class="admin-notification-content">
                                        <div class="admin-notification-title" style="color: #059669;">Balasan Meja Customer</div>
                                        <div class="admin-notification-message">
                                            <span x-text="repliedReservations + ' customer telah memilih meja, konfirmasi sekarang'"></span>
                                        </div>
                                        <div class="admin-notification-time">Segera konfirmasi</div>
                                    </div>
                                    <div class="admin-notification-count" x-text="repliedReservations" style="background: #10b981;"></div>
                                </div>
                            </div>
                            
                            <div class="admin-notification-footer">
                                <a href="{{ route('admin.pesanan') }}">
                                    📋 Kelola Semua Pesanan →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="sidebar-nav">
                <div class="nav-group">
                    <div class="nav-group-title">MAIN</div>
                    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </a>
                </div>
                
                <div class="nav-group">
                    <div class="nav-group-title">MANAJEMEN MENU</div>
                    <a href="{{ route('admin.menu.index') }}" class="nav-item {{ request()->routeIs('admin.menu.index') ? 'active' : '' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        Semua Menu
                    </a>
                    
                    <a href="{{ route('admin.popup-promo') }}" class="nav-item {{ request()->routeIs('admin.popup-promo') ? 'active' : '' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                        </svg>
                        Pop-up Promo
                    </a>
                    
                    <a href="{{ route('admin.gallery') }}" class="nav-item {{ request()->routeIs('admin.gallery') ? 'active' : '' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Galeri
                    </a>
                </div>
                
                <div class="nav-group">
                    <div class="nav-group-title">PESANAN & RESERVASI</div>
                    <a href="{{ route('admin.pesanan') }}" class="nav-item {{ request()->routeIs('admin.pesanan') ? 'active' : '' }}" id="nav-orders">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        Pesanan Masuk
                        <span class="nav-badge" x-show="newOrders > 0" x-text="newOrders" style="display: none;"></span>
                    </a>
                    <a href="{{ route('admin.reservasi') }}" class="nav-item {{ request()->routeIs('admin.reservasi') ? 'active' : '' }}" id="nav-reservations">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Reservasi Masuk
                        <span class="nav-badge" x-show="newReservations > 0" x-text="newReservations" style="display: none;"></span>
                    </a>
                </div>
                
                <div class="sidebar-footer">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-item" style="width: 100%; text-align: left;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="mobile-overlay" id="mobileOverlay" onclick="closeSidebar()"></div>
        
        <button class="mobile-menu-toggle" id="mobileMenuToggle" onclick="toggleSidebar()">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        
        <!-- Main Content -->
        <div class="admin-content">
            @yield('content')
        </div>
    </div>
    
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('mobileOverlay');
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('show');
        }
        
        function closeSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('mobileOverlay');
            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('show');
        }
        
        document.querySelectorAll('.nav-item, .dropdown-nav-item').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    closeSidebar();
                }
            });
        });
        
        // ==================== ADMIN NOTIFICATION DATA ====================
        function adminNotificationData() {
            return {
                dropdownOpen: false,
                newOrders: 0,
                newReservations: 0,
                repliedReservations: 0,
                totalUnread: 0,
                intervalId: null,
                
                initAdminNotification() {
                    this.fetchCounts();
                    this.intervalId = setInterval(() => {
                        this.fetchCounts();
                        if (this.totalUnread > 0) {
                            const bell = document.querySelector('.admin-notification-btn');
                            if (bell) {
                                bell.style.animation = 'bellRing 0.5s ease';
                                setTimeout(() => {
                                    bell.style.animation = '';
                                }, 500);
                            }
                        }
                    }, 15000);
                },
                
                toggleDropdown() {
                    this.dropdownOpen = !this.dropdownOpen;
                    if (this.dropdownOpen) {
                        this.fetchCounts();
                        // Adjust dropdown position
                        this.$nextTick(() => {
                            const dropdown = document.getElementById('notificationDropdown');
                            if (dropdown) {
                                const rect = dropdown.getBoundingClientRect();
                                if (rect.right > window.innerWidth) {
                                    dropdown.style.left = 'auto';
                                    dropdown.style.right = '10px';
                                }
                            }
                        });
                    }
                },
                
                fetchCounts() {
                    fetch('/admin/notifications/counts')
                        .then(res => res.json())
                        .then(data => {
                            this.newOrders = data.new_orders || 0;
                            this.newReservations = data.new_reservations || 0;
                            this.repliedReservations = data.replied_reservations || 0;
                            this.totalUnread = this.newOrders + this.newReservations + this.repliedReservations;
                            
                            // Update badge di menu navigasi
                            const ordersNav = document.getElementById('nav-orders');
                            const ordersBadge = ordersNav ? ordersNav.querySelector('.nav-badge') : null;
                            if (ordersBadge) {
                                if (this.newOrders > 0) {
                                    ordersBadge.textContent = this.newOrders;
                                    ordersBadge.style.display = 'inline-flex';
                                } else {
                                    ordersBadge.style.display = 'none';
                                }
                            }
                            
                            const reservationsNav = document.getElementById('nav-reservations');
                            const reservationsBadge = reservationsNav ? reservationsNav.querySelector('.nav-badge') : null;
                            if (reservationsBadge) {
                                const totalRes = this.newReservations + this.repliedReservations;
                                if (totalRes > 0) {
                                    reservationsBadge.textContent = totalRes;
                                    reservationsBadge.style.display = 'inline-flex';
                                } else {
                                    reservationsBadge.style.display = 'none';
                                }
                            }
                        })
                        .catch(err => console.error('Error fetching counts:', err));
                },
                
                goToOrders() {
                    window.location.href = '{{ route("admin.pesanan") }}';
                    this.dropdownOpen = false;
                },
                
                goToReservations() {
                    window.location.href = '{{ route("admin.reservasi") }}';
                    this.dropdownOpen = false;
                }
            }
        }
        
        document.addEventListener('alpine:init', () => {
            Alpine.data('adminNotificationData', adminNotificationData);
        });
    </script>
    
    @stack('scripts')
</body>
</html>