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

    {{-- Floating Testimoni Button --}}
    @auth
    <div x-data="testimonialWidget()" x-init="init" class="testimonial-floating">
        <!-- Tombol Floating - Hanya Icon -->
        <button @click="openModal = true" class="testimonial-btn">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
        </button>
        
        <!-- Modal Testimoni -->
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
            right: 30px;  /* ← Diubah dari left ke right */
            z-index: 999;
        }
        
        .testimonial-btn {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            border-radius: 50%;
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        }
        
        .testimonial-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.5);
        }
        
        .testimonial-btn svg {
            width: 28px;
            height: 28px;
            color: white;
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
                
                init() {
                    // Inisialisasi
                },
                
                submitTestimonial() {
                    // Validasi
                    if (this.message.trim().length < 10) {
                        alert('Testimoni minimal 10 karakter');
                        return;
                    }
                    
                    if (this.message.length > 500) {
                        alert('Testimoni maksimal 500 karakter');
                        return;
                    }
                    
                    this.loading = true;
                    
                    // Kirim data
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
                            alert('Terima kasih😊! Testimoni Anda telah terkirim.');
                            this.openModal = false;
                            this.message = '';
                            this.rating = 5;
                        } else {
                            alert(data.message || 'Gagal mengirim testimoni. Silakan coba lagi.');
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