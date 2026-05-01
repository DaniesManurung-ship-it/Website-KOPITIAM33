<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Café Kopitiam33') }} - @yield('title')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        /* ========== RESET & VARIABLES ========== */
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
            --dark: #4A3728;
            --gray: #6B7280;
            --gray-light: #F3F4F6;
            --white: #FFFFFF;
            --black: #1F2937;
            --success: #10B981;
            --success-dark: #059669;
            --danger: #EF4444;
            --warning: #F59E0B;
            --info: #3B82F6;
        }
        
        body {
            background: var(--cream);
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            color: var(--black);
        }
        
        /* ========== UTILITY CLASSES ========== */
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        
        .mt-1 { margin-top: 0.25rem; }
        .mt-2 { margin-top: 0.5rem; }
        .mt-3 { margin-top: 0.75rem; }
        .mt-4 { margin-top: 1rem; }
        .mb-1 { margin-bottom: 0.25rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-3 { margin-bottom: 0.75rem; }
        .mb-4 { margin-bottom: 1rem; }
        
        .p-1 { padding: 0.25rem; }
        .p-2 { padding: 0.5rem; }
        .p-3 { padding: 0.75rem; }
        .p-4 { padding: 1rem; }
        
        .flex { display: flex; }
        .inline-flex { display: inline-flex; }
        .items-center { align-items: center; }
        .justify-center { justify-content: center; }
        .justify-between { justify-content: space-between; }
        .gap-1 { gap: 0.25rem; }
        .gap-2 { gap: 0.5rem; }
        .gap-3 { gap: 0.75rem; }
        .gap-4 { gap: 1rem; }
        
        .flex-col { flex-direction: column; }
        .flex-wrap { flex-wrap: wrap; }
        
        .w-full { width: 100%; }
        .h-full { height: 100%; }
        
        .rounded { border-radius: 0.25rem; }
        .rounded-lg { border-radius: 0.5rem; }
        .rounded-xl { border-radius: 0.75rem; }
        .rounded-2xl { border-radius: 1rem; }
        
        .shadow { box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .shadow-md { box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
        .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); }
        
        .hidden { display: none; }
        
        [x-cloak] { display: none !important; }
        
        /* ========== MAIN CONTENT ========== */
        .main-content {
            min-height: calc(100vh - 60px);
        }
        
        /* ========== ANIMATIONS ========== */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            from {
                transform: translateY(10px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
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
        
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        
        .animate-slide-up {
            animation: slideUp 0.3s ease-out;
        }
        
        /* ========== TESTIMONI WIDGET STYLES ========== */
        .testimoni-widget-wrapper {
            position: fixed;
            bottom: 30px;
            left: 30px;
            z-index: 999;
        }
        
        .testimoni-widget-btn {
            background: linear-gradient(135deg, white 0%, #f8f6f2 100%);
            border: 2px solid var(--sage);
            border-radius: 50%;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            position: relative;
        }
        
        .testimoni-widget-btn:hover {
            background: linear-gradient(135deg, var(--sage) 0%, var(--wood) 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(139, 168, 136, 0.3);
        }
        
        .testimoni-widget-btn svg {
            width: 22px;
            height: 22px;
            color: var(--wood);
            transition: all 0.3s ease;
        }
        
        .testimoni-widget-btn:hover svg {
            color: white;
        }
        
        .testimoni-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            font-size: 9px;
            font-weight: bold;
            border-radius: 50%;
            min-width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 3px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }
        
        .testimoni-widget-dropdown {
            position: absolute;
            bottom: 58px;
            left: 0;
            width: 340px;
            max-width: calc(100vw - 40px);
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            overflow: hidden;
            animation: fadeIn 0.2s ease;
        }
        
        .testimoni-dropdown-header {
            padding: 10px 14px;
            background: linear-gradient(135deg, var(--sage) 0%, var(--wood) 100%);
            color: white;
        }
        
        .testimoni-dropdown-header h4 {
            margin: 0;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .testimoni-dropdown-body {
            max-height: 380px;
            overflow-y: auto;
            background: white;
        }
        
        .testimoni-list {
            padding: 0;
        }
        
        .testimoni-item {
            padding: 12px 14px;
            border-bottom: 1px solid #f0f0f0;
            transition: background 0.2s;
        }
        
        .testimoni-item:last-child {
            border-bottom: none;
        }
        
        .testimoni-item:hover {
            background: var(--cream);
        }
        
        .testimoni-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
        }
        
        .testimoni-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .user-avatar {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--sage) 0%, var(--wood) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 0.8rem;
        }
        
        .user-name {
            font-weight: 600;
            color: var(--wood);
            font-size: 0.8rem;
        }
        
        .testimoni-date {
            font-size: 0.55rem;
            color: #9ca3af;
        }
        
        .testimoni-rating {
            display: flex;
            gap: 2px;
            margin-top: 3px;
        }
        
        .testimoni-star {
            font-size: 0.6rem;
            color: #d1d5db;
        }
        
        .testimoni-star.active {
            color: #fbbf24;
        }
        
        .testimoni-message {
            font-size: 0.75rem;
            color: #4b5563;
            line-height: 1.45;
            margin-top: 6px;
            margin-left: 42px;
        }
        
        .testimoni-dropdown-footer {
            padding: 10px 14px;
            border-top: 1px solid #efefef;
            background: white;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        
        .btn-give-testimoni {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 12px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 0.75rem;
        }
        
        .btn-give-testimoni:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(16, 185, 129, 0.25);
        }
        
        .btn-view-all {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            padding: 7px 12px;
            background: #f3f4f6;
            color: var(--wood);
            font-size: 0.75rem;
            font-weight: 500;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.2s ease;
        }
        
        .btn-view-all:hover {
            background: #e5e7eb;
        }
        
        /* ========== MODAL STYLES ========== */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        
        .modal-overlay.active {
            display: flex;
        }
        
        .modal-container {
            background: white;
            border-radius: 1rem;
            max-width: 28rem;
            width: 100%;
            padding: 1.5rem;
            animation: slideUp 0.3s ease-out;
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .modal-title {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .modal-title-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--sage) 0%, var(--wood) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .modal-title-icon svg {
            width: 18px;
            height: 18px;
            color: white;
        }
        
        .modal-title h3 {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--wood);
        }
        
        .modal-close {
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            font-size: 1.5rem;
            transition: color 0.2s;
        }
        
        .modal-close:hover {
            color: #6b7280;
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.25rem;
        }
        
        .rating-stars {
            display: flex;
            gap: 0.25rem;
            font-size: 1.5rem;
        }
        
        .star-rating {
            cursor: pointer;
            color: #d1d5db;
            transition: all 0.15s;
        }
        
        .star-rating.active {
            color: #fbbf24;
        }
        
        .form-textarea {
            width: 100%;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-family: 'Poppins', sans-serif;
            transition: all 0.2s;
        }
        
        .form-textarea:focus {
            outline: none;
            border-color: var(--sage);
            ring: 2px solid var(--sage);
        }
        
        .form-buttons {
            display: flex;
            gap: 0.5rem;
        }
        
        .btn-submit {
            flex: 1;
            background: linear-gradient(135deg, var(--sage) 0%, var(--wood) 100%);
            color: white;
            padding: 0.5rem;
            border: none;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .btn-submit:hover {
            box-shadow: 0 4px 12px rgba(139, 168, 136, 0.3);
        }
        
        .btn-cancel {
            flex: 1;
            background: #f3f4f6;
            color: #4b5563;
            padding: 0.5rem;
            border: none;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .btn-cancel:hover {
            background: #e5e7eb;
        }
        
        /* ========== ORDER SUCCESS MODAL ========== */
        .order-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        
        .order-modal-overlay.active {
            display: flex;
        }
        
        .order-modal-container {
            background: white;
            border-radius: 1rem;
            max-width: 28rem;
            width: 100%;
            padding: 1.5rem;
            animation: slideUp 0.3s ease-out;
        }
        
        .order-modal-icon {
            width: 64px;
            height: 64px;
            background: rgba(16, 185, 129, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }
        
        .order-modal-icon svg {
            width: 32px;
            height: 32px;
            color: #10b981;
        }
        
        .order-modal-title {
            font-size: 1.5rem;
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            color: var(--wood);
            text-align: center;
            margin-bottom: 0.5rem;
        }
        
        .order-modal-message {
            color: #6b7280;
            text-align: center;
            margin-bottom: 1rem;
        }
        
        .order-modal-detail {
            background: rgba(139, 168, 136, 0.1);
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .order-modal-detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .order-modal-detail-label {
            font-weight: 500;
        }
        
        .order-modal-detail-value {
            font-weight: 700;
            color: var(--accent);
        }
        
        .order-modal-footer {
            text-align: center;
            color: #6b7280;
            margin-bottom: 1.5rem;
        }
        
        .order-modal-footer p {
            font-size: 0.875rem;
        }
        
        .order-modal-close {
            width: 100%;
            background: var(--accent);
            color: white;
            padding: 0.75rem;
            border: none;
            border-radius: 0.5rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .order-modal-close:hover {
            background: #c0392b;
        }
        
        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .testimoni-widget-dropdown {
                width: 320px;
                left: -10px;
                bottom: 55px;
            }
            
            .testimoni-widget-wrapper {
                bottom: 20px;
                left: 20px;
            }
            
            .testimoni-widget-btn {
                width: 44px;
                height: 44px;
            }
            
            .testimoni-widget-btn svg {
                width: 20px;
                height: 20px;
            }
            
            .testimoni-message {
                margin-left: 38px;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>

@unless(Route::is('login', 'register', 'admin.login*', 'admin.register*'))
    @include('layouts.navbar')
@endunless

<!-- Main Content -->
<main class="main-content">
    @yield('content')
</main>

<!-- Testimoni Widget -->
<div x-data="testimoniWidget()" x-init="init()" class="testimoni-widget-wrapper">
    <button @click="toggleDropdown()" class="testimoni-widget-btn">
        <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
        </svg>
        <span x-show="testimonialCount > 0" x-cloak class="testimoni-badge" x-text="testimonialCount"></span>
    </button>
    
    <div x-show="dropdownOpen" x-cloak @click.away="dropdownOpen = false" class="testimoni-widget-dropdown">
        <div class="testimoni-dropdown-header">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 bg-white/20 rounded-full flex items-center justify-center">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                </div>
                <h4>Testimoni Pelanggan</h4>
            </div>
        </div>
        
        <div class="testimoni-dropdown-body">
            <div x-show="testimonials.length > 0" class="testimoni-list">
                <template x-for="testimonial in testimonials" :key="testimonial.id">
                    <div class="testimoni-item">
                        <div class="testimoni-header">
                            <div class="testimoni-user">
                                <div class="user-avatar">
                                    <span x-text="testimonial.name.charAt(0).toUpperCase()"></span>
                                </div>
                                <div class="user-info">
                                    <span class="user-name" x-text="testimonial.name"></span>
                                    <div class="testimoni-rating">
                                        <template x-for="star in 5">
                                            <span class="testimoni-star" :class="{ 'active': star <= testimonial.rating }">★</span>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <span class="testimoni-date" x-text="formatDate(testimonial.created_at)"></span>
                        </div>
                        <div class="testimoni-message" x-text="testimonial.message"></div>
                    </div>
                </template>
            </div>
            <div x-show="testimonials.length === 0" class="empty-state" style="padding: 2rem; text-align: center; color: #9ca3af;">
                Belum ada testimoni
            </div>
        </div>
        
        <div class="testimoni-dropdown-footer">
            @auth
                <button @click="openModal()" class="btn-give-testimoni">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span>Tulis Testimoni</span>
                </button>
            @else
                <a href="{{ route('login') }}" class="btn-give-testimoni">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Login untuk Testimoni</span>
                </a>
            @endauth
            
            <a href="{{ route('testimonials.index') }}" class="btn-view-all">
                <span>Lihat Semua Testimoni</span>
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
</div>

<!-- Testimonial Modal -->
<div id="testimonialModal" class="modal-overlay">
    <div class="modal-container">
        <div class="modal-header">
            <div class="modal-title">
                <div class="modal-title-icon">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <h3>Beri Testimoni</h3>
            </div>
            <button onclick="closeTestimonialModal()" class="modal-close">&times;</button>
        </div>
        
        <form action="{{ route('testimonials.store') }}" method="POST" id="testimonialForm">
            @csrf
            <div class="form-group">
                <label class="form-label">Rating Anda</label>
                <div class="rating-stars" id="ratingStars">
                    <span class="star-rating" data-rating="1">★</span>
                    <span class="star-rating" data-rating="2">★</span>
                    <span class="star-rating" data-rating="3">★</span>
                    <span class="star-rating" data-rating="4">★</span>
                    <span class="star-rating" data-rating="5">★</span>
                </div>
                <input type="hidden" name="rating" id="rating" value="5">
            </div>
            
            <div class="form-group">
                <label class="form-label">Testimoni</label>
                <textarea name="message" rows="3" class="form-textarea" placeholder="Ceritakan pengalaman Anda di Café Kopitiam33..."></textarea>
            </div>
            
            <div class="form-buttons">
                <button type="submit" class="btn-submit">Kirim Testimoni</button>
                <button type="button" onclick="closeTestimonialModal()" class="btn-cancel">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- Order Success Modal -->
<div id="orderModal" class="order-modal-overlay">
    <div class="order-modal-container">
        <div class="order-modal-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h3 class="order-modal-title">Pesanan Berhasil!</h3>
        <p class="order-modal-message" id="orderMessage"></p>
        
        <div class="order-modal-detail">
            <div class="order-modal-detail-row">
                <span class="order-modal-detail-label" id="modalItemName">Nasi Goreng Spesial</span>
                <span class="order-modal-detail-value" id="modalItemPrice">Rp 35.000</span>
            </div>
            <div style="margin-top: 0.5rem;">
                <span>Jumlah: </span>
                <span id="modalItemQuantity">1</span>
                <span> porsi</span>
            </div>
        </div>
        
        <div class="order-modal-footer">
            <p>Silakan lakukan pembayaran di kasir.</p>
            <p style="font-size: 0.75rem; margin-top: 0.25rem;">Pesanan Anda telah dicatat dalam sistem kami.</p>
        </div>
        
        <button onclick="closeOrderModal()" class="order-modal-close">Tutup</button>
    </div>
</div>

<script>
    // Order Modal Functions
    function openOrderModal(itemName, itemPrice, itemQuantity = 1) {
        const modal = document.getElementById('orderModal');
        if (modal) {
            document.getElementById('modalItemName').textContent = itemName;
            document.getElementById('modalItemPrice').textContent = formatPrice(itemPrice);
            document.getElementById('modalItemQuantity').textContent = itemQuantity;
            document.getElementById('orderMessage').textContent = `"${itemName}" telah ditambahkan ke pesanan Anda.`;
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }
    
    function closeOrderModal() {
        const modal = document.getElementById('orderModal');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
    }
    
    // Testimonial Modal Functions
    function openTestimonialModal() {
        const modal = document.getElementById('testimonialModal');
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }
    
    function closeTestimonialModal() {
        const modal = document.getElementById('testimonialModal');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
            const form = document.getElementById('testimonialForm');
            if (form) form.reset();
            const ratingInput = document.getElementById('rating');
            if (ratingInput) ratingInput.value = 5;
            const stars = document.querySelectorAll('.star-rating');
            stars.forEach((star, index) => {
                if (index < 5) {
                    star.classList.add('active');
                } else {
                    star.classList.remove('active');
                }
            });
        }
    }
    
    // Format price to Indonesian Rupiah
    function formatPrice(price) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(price);
    }
    
    // Close modal on outside click
    document.getElementById('orderModal')?.addEventListener('click', function(event) {
        if (event.target === this) {
            closeOrderModal();
        }
    });
    
    document.getElementById('testimonialModal')?.addEventListener('click', function(event) {
        if (event.target === this) {
            closeTestimonialModal();
        }
    });
    
    // Testimoni Widget Alpine Component
    function testimoniWidget() {
        return {
            dropdownOpen: false,
            testimonials: [],
            testimonialCount: 0,
            
            init() {
                this.fetchTestimonials();
            },
            
            toggleDropdown() {
                this.dropdownOpen = !this.dropdownOpen;
                if (this.dropdownOpen && this.testimonials.length === 0) {
                    this.fetchTestimonials();
                }
            },
            
            fetchTestimonials() {
                fetch('/testimonials/latest')
                    .then(response => response.json())
                    .then(data => {
                        this.testimonials = data;
                        this.testimonialCount = data.length;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        this.testimonials = [];
                        this.testimonialCount = 0;
                    });
            },
            
            formatDate(dateString) {
                const date = new Date(dateString);
                const now = new Date();
                const diffTime = Math.abs(now - date);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                
                if (diffDays === 1) return 'Kemarin';
                if (diffDays < 7) return `${diffDays} hari lalu`;
                if (diffDays < 30) return `${Math.floor(diffDays / 7)} minggu lalu`;
                return `${Math.floor(diffDays / 30)} bulan lalu`;
            },
            
            openModal() {
                this.dropdownOpen = false;
                openTestimonialModal();
            }
        }
    }
    
    document.addEventListener('alpine:init', () => {
        Alpine.data('testimoniWidget', testimoniWidget);
    });
    
    // Star Rating Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.star-rating');
        const ratingInput = document.getElementById('rating');
        
        if (stars.length > 0 && ratingInput) {
            // Set default rating 5
            stars.forEach((star, index) => {
                if (index < 5) {
                    star.classList.add('active');
                }
            });
            
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.dataset.rating);
                    ratingInput.value = rating;
                    
                    stars.forEach((s, index) => {
                        if (index < rating) {
                            s.classList.add('active');
                        } else {
                            s.classList.remove('active');
                        }
                    });
                });
                
                star.addEventListener('mouseenter', function() {
                    const rating = parseInt(this.dataset.rating);
                    stars.forEach((s, index) => {
                        if (index < rating) {
                            s.style.color = '#fbbf24';
                        } else {
                            s.style.color = '#d1d5db';
                        }
                    });
                });
                
                star.addEventListener('mouseleave', function() {
                    const currentRating = parseInt(ratingInput.value);
                    stars.forEach((s, index) => {
                        if (index < currentRating) {
                            s.style.color = '#fbbf24';
                        } else {
                            s.style.color = '#d1d5db';
                        }
                    });
                });
            });
        }
        
        // Testimonial Form AJAX Submission
        const form = document.getElementById('testimonialForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const rating = document.getElementById('rating').value;
                const message = document.querySelector('textarea[name="message"]').value;
                
                if (!message || message.length < 10) {
                    alert('Testimoni minimal 10 karakter');
                    return;
                }
                
                const formData = new FormData();
                formData.append('rating', rating);
                formData.append('message', message);
                formData.append('_token', document.querySelector('input[name="_token"]').value);
                
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('✓ ' + data.message);
                        closeTestimonialModal();
                        // Refresh testimoni widget jika ada
                        const widgetElement = document.querySelector('[x-data="testimoniWidget()"]');
                        if (widgetElement && widgetElement.__x) {
                            widgetElement.__x.$data.fetchTestimonials();
                        }
                    } else {
                        alert('✗ ' + (data.message || 'Gagal mengirim testimoni'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan, silakan coba lagi');
                });
            });
        }
    });
</script>

@stack('scripts')
</body>
</html>