    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Café Kopitiam33') }} - @yield('title')</title>
        
        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="/favicon.ico">
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
        
        <!-- Swiper CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
        
        <!-- Alpine JS -->
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        
        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <!-- Custom Tailwind Config -->
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'sage': '#8BA888',
                            'cream': '#F5EFE6',
                            'wood': '#A67B5B',
                            'accent': '#D97642',
                        },
                        fontFamily: {
                            'sans': ['Poppins', 'sans-serif'],
                            'serif': ['Playfair Display', 'serif'],
                        },
                        animation: {
                            'fade-in': 'fadeIn 0.5s ease-in-out',
                            'slide-up': 'slideUp 0.3s ease-out',
                        },
                        keyframes: {
                            fadeIn: {
                                '0%': { opacity: '0' },
                                '100%': { opacity: '1' },
                            },
                            slideUp: {
                                '0%': { transform: 'translateY(10px)', opacity: '0' },
                                '100%': { transform: 'translateY(0)', opacity: '1' },
                            }
                        }
                    }
                }
            }
        </script>
        
        <style>
            .swiper-pagination-bullet-active {
                background-color: #D97642 !important;
            }
            .swiper-button-next, .swiper-button-prev {
                color: #D97642 !important;
            }
            .hover-lift {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }
            .hover-lift:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }
            .image-zoom {
                transition: transform 0.5s ease;
            }
            .image-zoom:hover {
                transform: scale(1.05);
            }
        </style>
        @stack('scripts')
        @stack('styles')
    </head>
    <body class="bg-cream font-sans text-gray-800">
        
        @unless(Request::is('login', 'register', 'admin/login', 'admin/*'))
            @include('layouts.navbar')
        @endunless

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>



        
        <!-- Order Success Modal -->
        @unless(Request::is('login', 'register', 'admin/login', 'admin/*'))
            <div id="orderModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
                <div class="bg-white rounded-2xl max-w-md w-full p-6 animate-slide-up">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-serif font-semibold text-wood mb-2">Pesanan Berhasil!</h3>
                        <p class="text-gray-600" id="orderMessage"></p>
                    </div>
                    
                    <div class="bg-cream/50 rounded-lg p-4 mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-medium" id="modalItemName">Nasi Goreng Spesial</span>
                            <span class="font-semibold text-wood" id="modalItemPrice">Rp 35.000</span>
                        </div>
                        <div class="text-sm text-gray-600">
                            Jumlah: <span id="modalItemQuantity">1</span> porsi
                        </div>
                    </div>
                    
                    <div class="text-center text-gray-600 mb-6">
                        <p class="font-medium">Silakan lakukan pembayaran di kasir.</p>
                        <p class="text-sm mt-2">Pesanan Anda telah dicatat dalam sistem kami.</p>
                    </div>
                    
                    <button onclick="closeOrderModal()" class="w-full bg-accent text-white py-3 rounded-lg font-medium hover:bg-wood transition">
                        Tutup
                    </button>
                </div>
            </div>


        @endunless

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        
        <script>
            // Mobile Menu Toggle
            document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
                document.getElementById('mobile-menu').classList.toggle('hidden');
            });

            // Close mobile menu when clicking outside
            document.addEventListener('click', function(event) {
                const mobileMenu = document.getElementById('mobile-menu');
                const menuButton = document.getElementById('mobile-menu-button');
                
                if (mobileMenu && menuButton) {
                    if (!mobileMenu.contains(event.target) && !menuButton.contains(event.target)) {
                        mobileMenu.classList.add('hidden');
                    }
                }
            });

            // Order Modal Functions
            function openOrderModal(itemName, itemPrice, itemImage = null) {
                const orderModal = document.getElementById('orderModal');
                if (orderModal) {
                    document.getElementById('modalItemName').textContent = itemName;
                    document.getElementById('modalItemPrice').textContent = formatPrice(itemPrice);
                    document.getElementById('orderMessage').textContent = `"${itemName}" telah ditambahkan ke pesanan Anda.`;
                    
                    orderModal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }
            }

            function closeOrderModal() {
                const orderModal = document.getElementById('orderModal');
                if (orderModal) {
                    orderModal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
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

            // Close modal when clicking outside
            document.getElementById('orderModal')?.addEventListener('click', function(event) {
                if (event.target === this) {
                    closeOrderModal();
                }
            });

            // Initialize Swiper on pages that need it
            document.addEventListener('DOMContentLoaded', function() {
                if (document.querySelector('.swiper-hero')) {
                    new Swiper('.swiper-hero', {
                        loop: true,
                        autoplay: {
                            delay: 4000,
                            disableOnInteraction: false,
                        },
                        pagination: {
                            el: '.swiper-pagination',
                            clickable: true,
                        },
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                    });
                }
                
                if (document.querySelector('.swiper-gallery')) {
                    new Swiper('.swiper-gallery', {
                        slidesPerView: 1,
                        spaceBetween: 20,
                        loop: true,
                        pagination: {
                            el: '.swiper-pagination',
                            clickable: true,
                        },
                        breakpoints: {
                            640: {
                                slidesPerView: 2,
                            },
                            1024: {
                                slidesPerView: 3,
                            },
                        },
                    });
                }
            });
        </script>
        
        @stack('scripts')
@props(['testimonials' => []])

<div x-data="testimoniWidget()" x-init="init()" class="testimoni-dropdown-wrapper">
    <!-- Tombol Dropdown - HANYA IKON, TANPA TULISAN -->
    <button @click="toggleDropdown()" class="testimoni-dropdown-btn">
        <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
        </svg>
        <span x-show="testimonialCount > 0" class="testimoni-badge" x-text="testimonialCount"></span>
    </button>
    
    <!-- Dropdown Content -->
    <div x-show="dropdownOpen" x-cloak @click.away="dropdownOpen = false" class="testimoni-dropdown">
        <div class="testimoni-dropdown-header">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 bg-white/20 rounded-full flex items-center justify-center">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                </div>
                <h4 class="font-semibold text-sm">Testimoni Pelanggan</h4>
            </div>
        </div>
        
        <div class="testimoni-dropdown-body">
            <!-- List Testimoni -->
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

<!-- Modal Testimoni -->
<div id="testimonialModal" class="fixed inset-0 bg-black/50 z-[1000] hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6">
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center gap-2">
                <div class="w-9 h-9 bg-gradient-to-r from-sage to-wood rounded-full flex items-center justify-center">
                    <svg width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-wood">Beri Testimoni</h3>
            </div>
            <button onclick="closeTestimonialModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>
        
        <form action="{{ route('testimonials.store') }}" method="POST" id="testimonialForm">
            @csrf
            <div class="mb-4">
                <label class="block text-xs font-medium text-gray-700 mb-1">Rating Anda</label>
                <div class="flex gap-1 text-2xl" id="ratingStars">
                    <span class="star-rating cursor-pointer transition" data-rating="1">★</span>
                    <span class="star-rating cursor-pointer transition" data-rating="2">★</span>
                    <span class="star-rating cursor-pointer transition" data-rating="3">★</span>
                    <span class="star-rating cursor-pointer transition" data-rating="4">★</span>
                    <span class="star-rating cursor-pointer transition" data-rating="5">★</span>
                </div>
                <input type="hidden" name="rating" id="rating" value="5">
            </div>
            
            <div class="mb-4">
                <label class="block text-xs font-medium text-gray-700 mb-1">Testimoni</label>
                <textarea name="message" rows="3" 
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-sage focus:border-transparent transition"
                    placeholder="Ceritakan pengalaman Anda di Café Kopitiam33..."></textarea>
            </div>
            
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-gradient-to-r from-sage to-wood text-white py-2 rounded-lg text-sm font-medium hover:shadow-md transition">
                    Kirim Testimoni
                </button>
                <button type="button" onclick="closeTestimonialModal()" class="flex-1 bg-gray-100 text-gray-700 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    :root {
        --sage: #8BA888;
        --wood: #A67B5B;
        --cream: #F5EFE6;
    }
    
    .testimoni-dropdown-wrapper {
        position: fixed;
        bottom: 30px;
        left: 30px;
        z-index: 999;
    }
    
    .testimoni-dropdown-btn {
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
    
    /* Hapus kemungkinan pseudo-element yang menambahkan teks */
    .testimoni-dropdown-btn::before,
    .testimoni-dropdown-btn::after {
        display: none;
        content: none;
    }
    
    .testimoni-dropdown-btn:hover {
        background: linear-gradient(135deg, var(--sage) 0%, var(--wood) 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(139, 168, 136, 0.3);
    }
    
    .testimoni-dropdown-btn svg {
        width: 22px;
        height: 22px;
        color: var(--wood);
        transition: all 0.3s ease;
    }
    
    .testimoni-dropdown-btn:hover svg {
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
        width: 16px;
        height: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }
    
    .testimoni-dropdown {
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
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
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
    
    .btn-give-testimoni svg {
        width: 14px;
        height: 14px;
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
    
    .btn-view-all svg {
        width: 12px;
        height: 12px;
    }
    
    .star-rating {
        color: #d1d5db;
        transition: all 0.15s;
        font-size: 1.5rem;
    }
    
    .star-rating.active {
        color: #fbbf24;
    }
    
    @media (max-width: 768px) {
        .testimoni-dropdown {
            width: 320px;
            left: -10px;
            bottom: 55px;
        }
        
        .testimoni-dropdown-wrapper {
            bottom: 20px;
            left: 20px;
        }
        
        .testimoni-dropdown-btn {
            width: 44px;
            height: 44px;
        }
        
        .testimoni-dropdown-btn svg {
            width: 20px;
            height: 20px;
        }
        
        .testimoni-message {
            margin-left: 38px;
        }
    }
</style>

<script>
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
    
    function openTestimonialModal() {
        const modal = document.getElementById('testimonialModal');
        if (modal) {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    }
    
    function closeTestimonialModal() {
        const modal = document.getElementById('testimonialModal');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
            const form = document.getElementById('testimonialForm');
            if (form) form.reset();
            const ratingInput = document.getElementById('rating');
            if (ratingInput) ratingInput.value = 5;
            const stars = document.querySelectorAll('.star-rating');
            stars.forEach((star, index) => {
                if (index < 5) {
                    star.classList.add('active');
                    star.style.color = '#fbbf24';
                } else {
                    star.classList.remove('active');
                    star.style.color = '#d1d5db';
                }
            });
        }
    }
    
    // Star rating functionality
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.star-rating');
        const ratingInput = document.getElementById('rating');
        
        if (stars.length > 0 && ratingInput) {
            stars.forEach((star, index) => {
                if (index < 5) {
                    star.classList.add('active');
                    star.style.color = '#fbbf24';
                }
            });
            
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.dataset.rating);
                    ratingInput.value = rating;
                    
                    stars.forEach((s, index) => {
                        if (index < rating) {
                            s.classList.add('active');
                            s.style.color = '#fbbf24';
                        } else {
                            s.classList.remove('active');
                            s.style.color = '#d1d5db';
                        }
                    });
                });
                
                star.addEventListener('mouseenter', function() {
                    const rating = parseInt(this.dataset.rating);
                    stars.forEach((s, index) => {
                        s.style.color = index < rating ? '#fbbf24' : '#d1d5db';
                    });
                });
                
                star.addEventListener('mouseleave', function() {
                    const currentRating = parseInt(ratingInput.value);
                    stars.forEach((s, index) => {
                        s.style.color = index < currentRating ? '#fbbf24' : '#d1d5db';
                    });
                });
            });
        }
        
        // Form submission with AJAX
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
                        const widget = document.querySelector('[x-data]').__x;
                        if (widget && widget.fetchTestimonials) {
                            widget.fetchTestimonials();
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
        
        // Close modal on outside click
        const modal = document.getElementById('testimonialModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeTestimonialModal();
                }
            });
        }
    });
</script>