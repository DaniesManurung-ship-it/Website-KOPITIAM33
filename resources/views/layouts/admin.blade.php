{{-- resources/views/layouts/admin.blade.php --}}
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
            --cream: #F5EFE6;
            --wood: #A67B5B;
            --accent: #D97642;
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
            padding: 1.5rem;
            border-bottom: 1px solid #f3f4f6;
            text-align: center;
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
        
        /* Improved Nav Item Styles */
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
        
        /* Improved Dropdown Styles */
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
        
        /* Left side content wrapper for dropdown button */
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
        
        /* Arrow icon styling */
        .dropdown-arrow {
            transition: transform 0.2s ease;
            width: 14px;
            height: 14px;
            flex-shrink: 0;
        }
        
        .dropdown-arrow.open {
            transform: rotate(180deg);
        }
        
        /* Dropdown content (submenu) */
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
        
        /* Scrollbar Styling */
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
                <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
                    <div class="sidebar-logo-circle">
                        <span class="sidebar-logo-text">CK</span>
                    </div>
                    <span class="sidebar-brand">Admin Kopitiam33</span>
                </a>
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
                    
                    <!-- Improved Dropdown Structure -->
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
                    <a href="{{ route('admin.pesanan') }}" class="nav-item {{ request()->routeIs('admin.pesanan') ? 'active' : '' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        Pesanan Masuk
                    </a>
                    <a href="{{ route('admin.reservasi') }}" class="nav-item {{ request()->routeIs('admin.reservasi') ? 'active' : '' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Reservasi Masuk
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
        
        // Close sidebar when clicking on a link (mobile)
        document.querySelectorAll('.nav-item, .dropdown-nav-item').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    closeSidebar();
                }
            });
        });
    </script>   
    
    @stack('scripts')
</body>
</html>