{{-- resources/views/layouts/sidebar.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - @yield('title', 'Café Kopitiam33')</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            --sage: #8BA888;
            --sage-dark: #6B8A6B;
            --sage-light: #E8F0E6;
            --cream: #F5EFE6;
            --wood: #A67B5B;
            --wood-dark: #8B5E3C;
            --accent: #D97642;
            --accent-dark: #c0392b;
            --danger: #ef4444;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: #F5EFE6;
        }
        
        /* Wrapper untuk sidebar dan konten */
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar Styles */
        .admin-sidebar {
            width: 280px;
            background: white;
            box-shadow: 2px 0 8px rgba(0,0,0,0.05);
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 100;
            overflow-y: auto;
            overflow-x: visible;
            transition: transform 0.3s;
        }
        
        /* Konten Utama */
        .admin-content {
            flex: 1;
            margin-left: 280px;
            padding: 1.5rem;
            min-height: 100vh;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-280px);
                overflow-x: hidden;
            }
            
            .admin-sidebar.mobile-open {
                transform: translateX(0);
            }
            
            .admin-content {
                margin-left: 0;
            }
        }
        
        /* Sidebar Header */
        .sidebar-header {
            padding: 1.2rem;
            border-bottom: 1px solid #f3f4f6;
            text-align: center;
            position: relative;
            background: white;
        }
        
        .sidebar-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
        }
        
        .sidebar-logo-circle {
            width: 40px;
            height: 40px;
            background: var(--sage);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .sidebar-logo-text {
            color: white;
            font-weight: bold;
        }
        
        .sidebar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            font-weight: 600;
            color: var(--wood);
        }
        
        /* ==================== NOTIFICATION BELL ==================== */
        .admin-notification-bell {
            position: relative;
            display: inline-block;
            margin-left: 0.5rem;
        }
        
        /* Wrapper untuk notification bell agar dropdown tidak terpotong */
        .notification-wrapper {
            position: relative;
            display: inline-block;
        }
        
        .admin-notification-btn {
            position: relative;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .admin-notification-btn:hover {
            background: var(--sage-light);
        }
        
        .admin-notification-btn svg {
            width: 22px;
            height: 22px;
            color: var(--wood);
            transition: color 0.2s ease;
        }
        
        .admin-notification-btn:hover svg {
            color: var(--accent);
        }
        
        .admin-notification-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: var(--danger);
            color: white;
            font-size: 0.6rem;
            font-weight: 600;
            border-radius: 50%;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
            animation: bellRing 0.5s ease infinite;
        }
        
        @keyframes bellRing {
            0% { transform: scale(1); }
            25% { transform: scale(1.15); background: #dc2626; }
            50% { transform: scale(1); }
            75% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        /* Notification Dropdown - muncul di sebelah kanan sidebar */
        .admin-notification-dropdown {
            position: fixed;
            top: 70px;
            left: 290px;
            width: 360px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px -8px rgba(0, 0, 0, 0.25);
            z-index: 1000;
            overflow: hidden;
            border: 1px solid rgba(139, 168, 136, 0.2);
            animation: dropdownSlide 0.25s ease;
        }
        
        /* Untuk mobile, dropdown muncul di tengah */
        @media (max-width: 768px) {
            .admin-notification-dropdown {
                position: fixed;
                top: 60px;
                left: 50%;
                transform: translateX(-50%);
                width: 90%;
                max-width: 360px;
            }
        }
        
        @keyframes dropdownSlide {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .admin-notification-header {
            padding: 0.8rem 1rem;
            background: linear-gradient(135deg, var(--sage) 0%, var(--wood) 100%);
            color: white;
        }
        
        .admin-notification-header h4 {
            font-size: 0.85rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        
        .admin-notification-header p {
            font-size: 0.65rem;
            opacity: 0.85;
            margin-top: 0.2rem;
            margin-bottom: 0;
        }
        
        .admin-notification-list {
            max-height: 380px;
            overflow-y: auto;
        }
        
        .admin-notification-item {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .admin-notification-item:hover {
            background: var(--cream);
        }
        
        .admin-notification-item.unread {
            background: #FFF8F0;
            border-left: 3px solid var(--accent);
        }
        
        .admin-notification-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }
        
        .admin-notification-icon.order {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        }
        
        .admin-notification-icon.reservation {
            background: linear-gradient(135deg, var(--sage) 0%, var(--wood) 100%);
        }
        
        .admin-notification-icon.info {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }
        
        .admin-notification-content {
            flex: 1;
            min-width: 0;
        }
        
        .admin-notification-title {
            font-size: 0.8rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.15rem;
        }
        
        .admin-notification-message {
            font-size: 0.7rem;
            color: #6b7280;
            line-height: 1.4;
            margin-bottom: 0.2rem;
        }
        
        .admin-notification-time {
            font-size: 0.6rem;
            color: #9ca3af;
        }
        
        .admin-notification-count {
            background: var(--danger);
            color: white;
            font-size: 0.7rem;
            font-weight: bold;
            border-radius: 20px;
            padding: 0.2rem 0.6rem;
            min-width: 28px;
            text-align: center;
        }
        
        .admin-notification-footer {
            padding: 0.7rem 1rem;
            background: #fafafa;
            border-top: 1px solid #f0f0f0;
            text-align: center;
        }
        
        .admin-notification-footer a {
            color: var(--sage);
            text-decoration: none;
            font-size: 0.7rem;
            font-weight: 500;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }
        
        .admin-notification-footer a:hover {
            color: var(--accent);
        }
        
        .empty-notification {
            padding: 1.5rem;
            text-align: center;
        }
        
        .empty-notification svg {
            width: 42px;
            height: 42px;
            margin-bottom: 0.5rem;
            opacity: 0.4;
        }
        
        .empty-notification p {
            font-size: 0.7rem;
            color: #9ca3af;
        }
        
        /* Sidebar Navigation */
        .sidebar-nav {
            padding: 1rem;
        }
        
        .nav-group {
            margin-bottom: 1.5rem;
        }
        
        .nav-group-title {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #9ca3af;
            margin-bottom: 0.5rem;
            padding-left: 0.75rem;
        }
        
        /* Nav Item Styles */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 1rem;
            border-radius: 0.5rem;
            color: #6b7280;
            text-decoration: none;
            transition: all 0.2s;
            margin-bottom: 0.25rem;
            position: relative;
        }
        
        .nav-item:hover {
            background: var(--cream);
            color: var(--wood);
        }
        
        .nav-item.active {
            background: var(--sage);
            color: white;
        }
        
        .nav-item.active svg {
            color: white;
        }
        
        .nav-item svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }
        
        .nav-badge {
            background: var(--danger);
            color: white;
            font-size: 0.6rem;
            font-weight: bold;
            border-radius: 20px;
            padding: 0.15rem 0.5rem;
            margin-left: auto;
            animation: bellRing 0.5s ease;
        }
        
        /* Dropdown Styles */
        .dropdown-nav {
            margin-bottom: 0.25rem;
        }
        
        .dropdown-nav-btn {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 0.6rem 1rem;
            border-radius: 0.5rem;
            color: #6b7280;
            background: none;
            border: none;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            font-size: 0.875rem;
            transition: all 0.2s;
        }
        
        .dropdown-nav-btn:hover {
            background: var(--cream);
            color: var(--wood);
        }
        
        .dropdown-nav-btn-content {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .dropdown-nav-btn-content svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }
        
        .dropdown-arrow {
            transition: transform 0.2s ease;
            width: 14px;
            height: 14px;
            flex-shrink: 0;
        }
        
        .dropdown-arrow.open {
            transform: rotate(180deg);
        }
        
        .dropdown-nav-content {
            padding-left: 2rem;
            margin-top: 0.25rem;
            margin-bottom: 0.25rem;
            display: none;
        }
        
        .dropdown-nav-content.show {
            display: block;
        }
        
        .dropdown-nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            color: #6b7280;
            text-decoration: none;
            font-size: 0.8rem;
            transition: all 0.2s;
            margin-bottom: 0.25rem;
        }
        
        .dropdown-nav-item:hover {
            background: var(--cream);
            color: var(--wood);
        }
        
        .dropdown-nav-item.active {
            background: var(--sage);
            color: white;
        }
        
        /* Sidebar Footer */
        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid #f3f4f6;
            margin-top: 1rem;
        }
        
        /* Mobile Toggle Button */
        .mobile-menu-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--sage);
            color: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            z-index: 101;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: none;
            align-items: center;
            justify-content: center;
        }
        
        .mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 99;
            display: none;
        }
        
        .mobile-overlay.show {
            display: block;
        }
        
        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: flex;
            }
        }
        
        /* Utility Classes */
        [x-cloak] {
            display: none !important;
        }
        
        .flex-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        /* Scrollbar */
        .admin-sidebar::-webkit-scrollbar {
            width: 4px;
        }
        
        .admin-sidebar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        .admin-sidebar::-webkit-scrollbar-thumb {
            background: var(--sage);
            border-radius: 2px;
        }
    </style>
    
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
                                            <span x-text="newReservations > 0 ? newReservations + ' reservasi menunggu konfirmasi' : 'Tidak ada reservasi baru'"></span>
                                        </div>
                                        <div class="admin-notification-time" x-show="newReservations > 0">Perlu segera dikonfirmasi</div>
                                    </div>
                                    <div class="admin-notification-count" x-show="newReservations > 0" x-text="newReservations"></div>
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
                    
                    <div class="dropdown-nav" x-data="{ open: {{ request()->routeIs('admin.menu-spesial') || request()->routeIs('admin.promo') ? 'true' : 'false' }} }">
                        <button @click="open = !open" class="dropdown-nav-btn">
                            <div class="dropdown-nav-btn-content">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                <span>Menu Lainnya</span>
                            </div>
                            <svg class="dropdown-arrow" :class="{ 'open': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="dropdown-nav-content" :class="{ 'show': open }">
                            <a href="{{ route('admin.menu-spesial') }}" class="dropdown-nav-item {{ request()->routeIs('admin.menu-spesial') ? 'active' : '' }}">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="14" height="14">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                                Menu Spesial
                            </a>
                            <a href="{{ route('admin.promo') }}" class="dropdown-nav-item {{ request()->routeIs('admin.promo') ? 'active' : '' }}">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="14" height="14">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                                </svg>
                                Promo
                            </a>
                        </div>
                    </div>
                    
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
                            this.totalUnread = this.newOrders + this.newReservations;
                            
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
                                if (this.newReservations > 0) {
                                    reservationsBadge.textContent = this.newReservations;
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